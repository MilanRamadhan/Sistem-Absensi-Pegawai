@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Daftar Pengajuan Izin Saya</h1> {{-- Consistent h1 --}}
<a href="{{ route('pegawai.izin.create') }}"
    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300 mb-6 inline-block">Ajukan
    Izin Baru</a> {{-- Consistent button styling --}}

<div class="bg-white shadow-md rounded-lg overflow-hidden"> {{-- Consistent card styling --}}
    <div class="bg-blue-600 text-white px-6 py-4 font-semibold text-lg"> {{-- Consistent card-header styling --}}
        Riwayat Pengajuan Izin
    </div>
    <div class="overflow-x-auto"> {{-- Consistent table responsive --}}
        <table class="min-w-full divide-y divide-gray-200"> {{-- Consistent table styling --}}
            <thead class="bg-gray-800 text-white"> {{-- Consistent table head --}}
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal
                        Mulai</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal
                        Selesai</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jenis Izin
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Alasan
                        Singkat</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Bukti File
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status
                        Admin</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Catatan
                        Admin</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Diajukan
                        Pada</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($izin as $i)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $i->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($i->tanggal_mulai)->format('d F Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($i->tanggal_selesai)->format('d F Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $i->jenis_izin }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($i->alasan, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($i->bukti_file)
                        <a href="{{ Storage::url($i->bukti_file) }}" target="_blank"
                            class="text-blue-600 hover:underline">Lihat Bukti</a> {{-- Consistent link styling --}}
                        @else
                        -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($i->status_admin == 'pending')
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            {{-- Tailwind badge --}}
                            {{ ucfirst($i->status_admin) }}
                        </span>
                        @elseif ($i->status_admin == 'disetujui')
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{-- Tailwind badge --}}
                            {{ ucfirst($i->status_admin) }}
                        </span>
                        @else
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            {{-- Tailwind badge --}}
                            {{ ucfirst($i->status_admin) }}
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $i->catatan_admin ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $i->created_at->format('d F Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Belum ada pengajuan
                        izin.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection