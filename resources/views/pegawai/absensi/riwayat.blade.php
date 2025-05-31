@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Absensi Bulanan</h1>

{{-- Filter Card --}}
<div class="bg-white shadow-md rounded-lg p-6 mb-6"> {{-- Consistent card styling --}}
    <div class="font-semibold text-lg text-blue-800 mb-4"> {{-- Consistent card-header styling --}}
        Filter Riwayat Absensi
    </div>
    <div>
        <form action="{{ route('pegawai.absensi.riwayat') }}" method="GET"
            class="flex flex-wrap items-center space-x-4"> {{-- Consistent form layout --}}
            <div class="flex-shrink-0">
                <label for="month" class="sr-only">Bulan</label>
                <select name="month" id="month"
                    class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    {{-- Consistent select styling --}}
                    @foreach($months as $num => $name)
                    <option value="{{ $num }}" {{ $num == $currentMonth ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-shrink-0">
                <label for="year" class="sr-only">Tahun</label>
                <select name="year" id="year"
                    class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    {{-- Consistent select styling --}}
                    @foreach($years as $year)
                    <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-shrink-0">
                <button type="submit"
                    class="px-4 py-2 bg-gray-800 text-white font-bold rounded-md hover:bg-gray-900 transition duration-300">Filter</button>
                {{-- Consistent button styling --}}
            </div>
        </form>
    </div>
</div>

{{-- Data Absensi Table Card --}}
<div class="bg-white shadow-md rounded-lg overflow-hidden"> {{-- Consistent card styling --}}
    <div class="bg-blue-600 text-white px-6 py-4 font-semibold text-lg"> {{-- Consistent card-header styling --}}
        Data Absensi Bulan {{ \Carbon\Carbon::create()->month($currentMonth)->translatedFormat('F') }} Tahun
        {{ $currentYear }}
    </div>
    <div class="overflow-x-auto"> {{-- Consistent table responsive --}}
        <table class="min-w-full divide-y divide-gray-200"> {{-- Consistent table styling --}}
            <thead class="bg-gray-800 text-white"> {{-- Consistent table head --}}
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Waktu Masuk
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Waktu
                        Pulang</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Keterangan
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($absensiBulanan as $absensi)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d F Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $absensi->waktu_masuk ? \Carbon\Carbon::parse($absensi->waktu_masuk)->format('H:i:s') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $absensi->waktu_pulang ? \Carbon\Carbon::parse($absensi->waktu_pulang)->format('H:i:s') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($absensi->status == 'hadir')
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{-- Tailwind badge --}}
                            {{ ucfirst($absensi->status) }}
                        </span>
                        @elseif (in_array($absensi->status, ['izin', 'cuti', 'sakit']))
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{-- Tailwind badge --}}
                            {{ ucfirst($absensi->status) }}
                        </span>
                        @else
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            {{-- Tailwind badge --}}
                            {{ ucfirst($absensi->status) }}
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $absensi->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Belum ada riwayat
                        absensi untuk bulan ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection