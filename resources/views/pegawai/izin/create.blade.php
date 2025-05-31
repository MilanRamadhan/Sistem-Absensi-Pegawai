@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Form Pengajuan Izin Tidak Hadir</h1> {{-- Consistent h1 --}}
<a href="{{ route('pegawai.izin.index') }}"
    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition duration-300 mb-6 inline-block">Kembali
    ke Daftar Izin</a> {{-- Consistent button styling --}}

<div class="bg-white shadow-md rounded-lg p-6"> {{-- Consistent card styling --}}
    <div class="font-semibold text-lg text-blue-800 mb-4"> {{-- Consistent card-header styling --}}
        Ajukan Izin Baru
    </div>
    <div> {{-- Consistent card-body styling (removed card-body div) --}}
        <form action="{{ route('pegawai.izin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf {{-- Token CSRF untuk keamanan form --}}

            <div class="mb-4"> {{-- Consistent margin-bottom --}}
                <label for="tanggal_mulai" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai
                    Izin:</label> {{-- Consistent label styling --}}
                <input type="date"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tanggal_mulai') border-red-500 @enderror"
                    id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                {{-- Consistent input styling --}}
                @error('tanggal_mulai')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                {{-- Consistent error message styling --}}
                @enderror
            </div>

            <div class="mb-4">
                <label for="tanggal_selesai" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Selesai
                    Izin:</label>
                <input type="date"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tanggal_selesai') border-red-500 @enderror"
                    id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                @error('tanggal_selesai')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="jenis_izin" class="block text-gray-700 text-sm font-bold mb-2">Jenis Izin:</label>
                <select
                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('jenis_izin') border-red-500 @enderror"
                    id="jenis_izin" name="jenis_izin" required> {{-- Consistent select styling --}}
                    <option value="">Pilih Jenis Izin</option>
                    <option value="Sakit" {{ old('jenis_izin') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="Pribadi" {{ old('jenis_izin') == 'Pribadi' ? 'selected' : '' }}>Pribadi (Keperluan
                        Mendesak)</option>
                    <option value="Cuti" {{ old('jenis_izin') == 'Cuti' ? 'selected' : '' }}>Cuti (Harap Ajukan Jauh
                        Hari)</option>
                </select>
                @error('jenis_izin')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="alasan" class="block text-gray-700 text-sm font-bold mb-2">Alasan:</label>
                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('alasan') border-red-500 @enderror"
                    id="alasan" name="alasan" rows="4" required>{{ old('alasan') }}</textarea>
                {{-- Consistent textarea styling --}}
                @error('alasan')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6"> {{-- Increased margin-bottom for last input before button --}}
                <label for="bukti_file" class="block text-gray-700 text-sm font-bold mb-2">Unggah Bukti (Opsional,
                    PDF/gambar):</label>
                <input type="file"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('bukti_file') border-red-500 @enderror"
                    id="bukti_file" name="bukti_file"> {{-- Consistent file input styling --}}
                @error('bukti_file')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
                <small class="block text-gray-500 text-xs mt-1">Maksimal 2MB. Format: JPG, PNG, PDF.</small>
                {{-- Consistent small text styling --}}
            </div>

            <button type="submit"
                class="px-6 py-3 bg-green-600 text-white font-bold rounded-md hover:bg-green-700 transition duration-300">Ajukan
                Izin</button> {{-- Consistent button styling --}}
        </form>
    </div>
</div>
@endsection