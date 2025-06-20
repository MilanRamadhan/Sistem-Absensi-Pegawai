<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Sistem Kepegawaian') }}</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Vite (untuk Laravel Breeze CSS/JS dan aset kustom) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    {{-- Bagian navigasi yang akan di-include dari navigation.blade.php --}}
    {{-- Catatan: navigation.blade.php akan perlu diubah ke Tailwind juga --}}
    @include('layouts.navigation')

    <div class="container mx-auto mt-8 p-4">
        {{-- Menampilkan pesan sukses dari controller (flash message) --}}
        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        {{-- Menampilkan pesan error dari controller (flash message) --}}
        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        {{-- Menampilkan error validasi form --}}
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Konten dari setiap view anak akan disuntikkan di sini --}}
        @yield('content')
    </div>

    {{-- Script untuk Bootstrap JS (TIDAK LAGI DIBUTUHKAN JIKA MENGGUNAKAN TAILWIND) --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
    @stack('scripts') {{-- Untuk script kustom seperti GPS --}}
</body>

</html>