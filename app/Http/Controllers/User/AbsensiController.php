<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        // Ambil status absensi hari ini untuk user yang login
        $today = Carbon::today();
        $absensiHariIni = Absensi::where('user_id', auth()->id())
                                 ->whereDate('tanggal', $today)
                                 ->first();

        return view('pegawai.absensi.index', compact('absensiHariIni'));
    }

    // Metode untuk menangani absen masuk
    public function absenMasuk(Request $request)
    {
        $request->validate([
            'latitude_masuk' => 'required|numeric',
            'longitude_masuk' => 'required|numeric',
        ]);

        $user = auth()->user();
        $now = Carbon::now();
        
        // Cek apakah hari ini hari libur
        if ($this->isHariLibur($now)) {
            return redirect()->route('pegawai.absensi.index')
                             ->with('error', 'Hari ini adalah hari libur. Absensi tidak dapat dilakukan.');
        }

        // Cek waktu absen masuk (misal: 06:00 - 09:00)
        $jamMulai = Carbon::createFromTime(6, 0, 0);
        $jamAkhir = Carbon::createFromTime(9, 0, 0);
        
        if ($now->format('H:i:s') < $jamMulai->format('H:i:s') || $now->format('H:i:s') > $jamAkhir->format('H:i:s')) {
            return redirect()->route('pegawai.absensi.index')
                             ->with('error', 'Absen masuk hanya dapat dilakukan antara pukul 06:00 - 09:00.');
        }

        $userLat = $request->latitude_masuk;
        $userLong = $request->longitude_masuk;

        // --- HITUNG JARAK MENGGUNAKAN RUMUS HAVERSINE ---
        $distance = $this->haversineGreatCircleDistance(
            $user->lat_lokasi_kerja, $user->long_lokasi_kerja,
            $userLat, $userLong
        );

        $radiusToleransi = $user->radius_toleransi; // Dalam meter

        // Periksa apakah user berada dalam radius toleransi
        if ($distance > $radiusToleransi) {
            return redirect()->route('pegawai.absensi.index')
                             ->with('error', 'Anda berada ' . round($distance) . ' meter dari lokasi kantor. Absen masuk hanya bisa dilakukan dalam jarak ' . $radiusToleransi . ' meter.');
        }

        // Cek apakah sudah absen masuk hari ini
        $today = Carbon::today();
        $existingAbsensi = Absensi::where('user_id', $user->id)
                                  ->whereDate('tanggal', $today)
                                  ->first();

        if ($existingAbsensi && $existingAbsensi->waktu_masuk) {
            return redirect()->route('pegawai.absensi.index')
                             ->with('error', 'Anda sudah absen masuk hari ini pada ' . Carbon::parse($existingAbsensi->waktu_masuk)->format('H:i:s') . '.');
        }

        // Jika belum ada absensi hari ini, buat record baru
        if (!$existingAbsensi) {
            Absensi::create([
                'user_id' => $user->id,
                'tanggal' => $today,
                'waktu_masuk' => Carbon::now(),
                'lat_masuk' => $userLat,
                'long_masuk' => $userLong,
                'status' => 'hadir', // Default status hadir
            ]);
        } else {
            // Jika sudah ada absensi tapi belum masuk (misalnya status izin), update waktu_masuk
            $existingAbsensi->update([
                'waktu_masuk' => Carbon::now(),
                'lat_masuk' => $userLat,
                'long_masuk' => $userLong,
                'status' => 'hadir', // Pastikan status hadir
            ]);
        }

        return redirect()->route('pegawai.absensi.index')
                         ->with('success', 'Absen masuk berhasil pada ' . Carbon::now()->format('H:i:s') . '.');
    }

    // Metode untuk menangani absen pulang
    public function absenPulang(Request $request)
    {
        $request->validate([
            'latitude_pulang' => 'required|numeric',
            'longitude_pulang' => 'required|numeric',
        ]);

        $user = auth()->user();
        $now = Carbon::now();
        
        // Cek waktu absen pulang (misal: 16:00 - 20:00)
        $jamMulai = Carbon::createFromTime(16, 0, 0);
        $jamAkhir = Carbon::createFromTime(20, 0, 0);
        
        if ($now->format('H:i:s') < $jamMulai->format('H:i:s') || $now->format('H:i:s') > $jamAkhir->format('H:i:s')) {
            return redirect()->route('pegawai.absensi.index')
                             ->with('error', 'Absen pulang hanya dapat dilakukan antara pukul 16:00 - 20:00.');
        }

        $userLat = $request->latitude_pulang;
        $userLong = $request->longitude_pulang;

        // --- HITUNG JARAK MENGGUNAKAN RUMUS HAVERSINE (Opsional untuk Pulang) ---
        // Anda bisa memutuskan apakah absen pulang juga harus di lokasi kantor atau tidak.
        // Untuk contoh ini, kita tidak wajibkan di lokasi kantor saat pulang.
        // Jika mau wajibkan, salin logika perhitungan jarak dari absenMasuk.

        $absensi = Absensi::where('user_id', $user->id)
                          ->whereDate('tanggal', Carbon::today())
                          ->first();

        // Cek apakah sudah absen masuk
        if (!$absensi || !$absensi->waktu_masuk) {
            return redirect()->route('pegawai.absensi.index')
                             ->with('error', 'Anda belum absen masuk hari ini.');
        }

        // Cek apakah sudah absen pulang
        if ($absensi->waktu_pulang) {
            return redirect()->route('pegawai.absensi.index')
                             ->with('error', 'Anda sudah absen pulang hari ini pada ' . Carbon::parse($absensi->waktu_pulang)->format('H:i:s') . '.');
        }

        $absensi->update([
            'waktu_pulang' => Carbon::now(),
            'lat_pulang' => $userLat,
            'long_pulang' => $userLong,
        ]);

        return redirect()->route('pegawai.absensi.index')
                         ->with('success', 'Absen pulang berhasil pada ' . Carbon::now()->format('H:i:s') . '.');
    }

    // Metode untuk riwayat absensi bulanan (akan kita isi nanti)
    public function riwayatBulanan(Request $request) // Tambahkan Request $request
    {
        $userId = auth()->id();
        $currentMonth = $request->input('month', Carbon::now()->month);
        $currentYear = $request->input('year', Carbon::now()->year);

        // Ambil semua absensi untuk user_id tertentu dalam bulan dan tahun yang dipilih
        $absensiBulanan = Absensi::where('user_id', $userId)
                                ->whereMonth('tanggal', $currentMonth)
                                ->whereYear('tanggal', $currentYear)
                                ->orderBy('tanggal', 'desc')
                                ->get();

        // Untuk navigasi bulan/tahun
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[$m] = Carbon::create()->month($m)->translatedFormat('F'); // 'F' for full month name
        }
        $years = range(Carbon::now()->year - 2, Carbon::now()->year + 1); // 3 tahun ke belakang, 1 tahun ke depan

        return view('pegawai.absensi.riwayat', compact('absensiBulanan', 'currentMonth', 'currentYear', 'months', 'years'));
    }


    // --- FUNGSI RUMUS HAVERSINE UNTUK MENGHITUNG JARAK ---
    private function haversineGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) // Earth radius in meters
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius; // Result in meters
    }

    // Tambahkan method untuk cek hari libur
    private function isHariLibur($date)
    {
        // Daftar hari libur nasional (contoh)
        $hariLibur = [
            '01-01', // Tahun Baru
            '05-01', // Hari Buruh
            '08-17', // Hari Kemerdekaan
            '12-25', // Hari Natal
        ];

        // Cek apakah hari ini hari libur
        if (in_array($date->format('m-d'), $hariLibur)) {
            return true;
        }

        // Cek apakah hari ini weekend (Sabtu/Minggu)
        if ($date->isWeekend()) {
            return true;
        }

        return false;
    }
}