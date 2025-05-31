@extends('layouts.app')

@section('content')
<h1>Detail Pegawai: {{ $pegawai->nama }}</h1>
<a href="{{ route('pegawai.index') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Pegawai</a>

<div class="card">
    <div class="card-header">
        Informasi Lengkap Pegawai
    </div>
    <div class="card-body">
        <p><strong>Nama:</strong> {{ $pegawai->nama }}</p>
        <p><strong>NIP:</strong> {{ $pegawai->nip }}</p>
        <p><strong>Jabatan:</strong> {{ $pegawai->jabatan }}</p>
        <p><strong>Tanggal Lahir:</strong> {{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y') }}</p>
        <p><strong>Alamat:</strong> {{ $pegawai->alamat }}</p>
        <hr>
        <p class="text-muted small"><strong>Dibuat pada:</strong> {{ $pegawai->created_at->format('d F Y, H:i:s') }}</p>
        <p class="text-muted small"><strong>Terakhir Diperbarui:</strong>
            {{ $pegawai->updated_at->format('d F Y, H:i:s') }}</p>
    </div>
    <div class="card-footer">
        <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini? Data tidak bisa dikembalikan!')">Hapus</button>
        </form>
    </div>
</div>
@endsection