<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IzinTidakHadir;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class IzinController extends Controller
{
    public function index()
    {
        $izin = IzinTidakHadir::where('user_id', Auth::id())
                               ->orderBy('created_at', 'desc')
                               ->get();
        return view('pegawai.izin.index', compact('izin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pegawai.izin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Pengajuan Izin - Request received:', $request->all());
        Log::info('Pengajuan Izin - File exists (hasFile):', ['hasFile' => $request->hasFile('bukti_file')]);

        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis_izin' => 'required|string|in:Sakit,Pribadi,Cuti',
            'alasan' => 'required|string|max:500',
            'bukti_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Cek tumpang tindih dengan izin yang sudah ada
        $tumpangTindih = IzinTidakHadir::where('user_id', Auth::id())
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                    });
            })
            ->where('status_admin', '!=', 'ditolak')
            ->exists();

        if ($tumpangTindih) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tanggal izin yang diajukan tumpang tindih dengan izin yang sudah ada.');
        }

        
        if ($request->hasFile('bukti_file')) {
            $uploadedFile = $request->file('bukti_file');

            Log::info('Pengajuan Izin - Uploaded File Details:', [
                'isValid' => $uploadedFile->isValid(),        // Apakah file valid (UPLOAD_ERR_OK)
                'getError' => $uploadedFile->getError(),      // Kode error PHP (0 = tidak ada error)
                'errorMessage' => $uploadedFile->getErrorMessage(), // Pesan error PHP
                'getRealPath' => $uploadedFile->getRealPath(), // Path file temporer
                'getClientOriginalName' => $uploadedFile->getClientOriginalName(),
                'getClientMimeType' => $uploadedFile->getClientMimeType(),
                'getSize' => $uploadedFile->getSize(),
                'isWritableTempDir' => is_writable(sys_get_temp_dir()), // Cek izin direktori temp sistem
                'tempDir' => sys_get_temp_dir(), // Path ke direktori temp sistem
            ]);

            try {
                $filePath = $request->file('bukti_file')->store('izin_bukti', 'public');
                Log::info('Pengajuan Izin - File stored successfully:', ['path' => $filePath]);
            } catch (\Exception $e) {
                Log::error('Pengajuan Izin - File upload failed:', [
                    'exception_message' => $e->getMessage(),
                    'file_details_after_exception' => [ // Detail file saat exception terjadi
                        'isValid' => $uploadedFile->isValid(),
                        'getError' => $uploadedFile->getError(),
                        'errorMessage' => $uploadedFile->getErrorMessage(),
                        'getRealPath' => $uploadedFile->getRealPath(),
                    ],
                    'trace' => $e->getTraceAsString(),
                ]);
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengunggah file bukti: ' . $e->getMessage());
            }
        } else {
            Log::info('Pengajuan Izin - No file was uploaded by the user.');
        }

        $izin = IzinTidakHadir::create([
            'user_id' => Auth::id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis_izin' => $request->jenis_izin,
            'alasan' => $request->alasan,
            'bukti_file' => $filePath,
            'status_admin' => 'pending',
        ]);

        // Kirim notifikasi ke admin (implementasi bisa menggunakan Laravel Notification)
        Notification::send(User::where('role', 'admin')->get(), new IzinBaruNotification($izin));

        return redirect()->route('pegawai.izin.index')
            ->with('success', 'Pengajuan izin berhasil diajukan. Menunggu persetujuan admin.');
    }

    /**
     * Display the specified resource. (Tidak digunakan di sini, hanya untuk admin via Filament)
     */
    public function show(string $id)
    {
        // Tidak perlu implementasi di sini karena admin akan melihat detail via Filament
    }

    /**
     * Show the form for editing the specified resource. (Tidak digunakan di sini)
     */
    public function edit(string $id)
    {
        // Tidak perlu implementasi di sini
    }

    /**
     * Update the specified resource in storage. (Tidak digunakan di sini)
     */
    public function update(Request $request, string $id)
    {
        // Tidak perlu implementasi di sini
    }

    /**
     * Remove the specified resource from storage. (Tidak digunakan di sini)
     */
    public function destroy(string $id)
    {
        // Tidak perlu implementasi di sini
    }
}