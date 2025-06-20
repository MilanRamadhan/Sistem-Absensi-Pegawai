@extends('layouts.app') {{-- Pastikan ini tetap ada --}}

@section('content') {{-- Pastikan ini tetap ada --}}
{{-- Ini adalah konten yang akan disuntikkan ke @yield('content') di layouts/app.blade.php --}}

<h2 class="text-xl font-semibold text-gray-800 leading-tight mb-4"> {{-- Kelas Tailwind --}}
    {{ __('Dashboard') }}
</h2>

<div class="p-6 bg-white shadow-md rounded-lg"> {{-- Kelas Tailwind: p-6 (padding), bg-white, shadow-md, rounded-lg --}}
    {{-- Pesan umum setelah login --}}
    <p class="mb-4 text-gray-900">{{ __("You're logged in!") }}</p> {{-- Kelas Tailwind: mb-4, text-gray-900 --}}

    {{-- Tampilkan pesan dan link yang relevan berdasarkan role --}}
    @if(Auth::user()->isAdmin())
    <p class="mt-2 text-gray-900">Anda login sebagai <span class="font-bold">Admin</span>.</p> {{-- Kelas Tailwind --}}
    <p class="mt-2 text-gray-900">Silakan menuju <a href="{{ route('admin.dashboard') }}"
            class="text-blue-600 hover:underline">Dashboard Admin</a> atau <a href="{{ url('/admin') }}"
            class="text-blue-600 hover:underline">Panel Admin (Filament)</a>
        untuk mengelola sistem.</p>
    @else {{-- Ini berarti user adalah pegawai --}}
    <p class="mt-2 text-gray-900">Anda login sebagai <span class="font-bold">Pegawai</span>.</p>
    {{-- Kelas Tailwind --}}
    <p class="mt-2 text-gray-900">Selamat datang, <span class="font-bold">{{ Auth::user()->name }}</span>!</p>
    {{-- Kelas Tailwind --}}
    <p class="mt-2 text-gray-900">Di sini Anda bisa mengakses fitur-fitur absensi dan izin.</p> {{-- Kelas Tailwind --}}
    <div class="mt-4 flex space-x-3"> {{-- Kelas Tailwind: mt-4, flex, space-x-3 --}}
        <a href="{{ route('pegawai.absensi.index') }}"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Absensi Harian</a>
        {{-- Kelas Tailwind untuk tombol --}}
        <a href="{{ route('pegawai.absensi.riwayat') }}"
            class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600">Riwayat Absensi</a>
        {{-- Kelas Tailwind untuk tombol --}}
        <a href="{{ route('pegawai.izin.index') }}"
            class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Pengajuan Izin</a>
        {{-- Kelas Tailwind untuk tombol --}}
    </div>
    @endif
</div>
@endsection