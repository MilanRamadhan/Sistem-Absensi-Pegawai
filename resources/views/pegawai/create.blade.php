@extends('layouts.app')

@section('content')
<h1>Tambah Pegawai Baru</h1>
<a href="{{ route('pegawai.index') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Pegawai</a>

<form action="{{ route('pegawai.store') }}" method="POST">
    @csrf {{-- Token CSRF untuk keamanan form --}}

    <div class="mb-3">
        <label for="nama" class="form-label">Nama Pegawai:</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
            value="{{ old('nama') }}" required>
        @error('nama') {{-- Menampilkan pesan error validasi jika ada --}}
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="nip" class="form-label">NIP:</label>
        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip"
            value="{{ old('nip') }}" required>
        @error('nip')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="jabatan" class="form-label">Jabatan:</label>
        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan"
            value="{{ old('jabatan') }}" required>
        @error('jabatan')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="tanggal_lahir" class="form-label">Tanggal Lahir:</label>
        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir"
            name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
        @error('tanggal_lahir')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat:</label>
        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
            required>{{ old('alamat') }}</textarea>
        @error('alamat')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Simpan Data Pegawai</button>
</form>
@endsection