@extends('layouts.app') {{-- Menggunakan layout dasar yang sudah dibuat --}}

@section('content') {{-- Mengisi bagian 'content' dari layout --}}
<h1>Daftar Pegawai</h1>
<a href="{{ route('pegawai.create') }}" class="btn btn-primary mb-3">Tambah Pegawai</a>


<div class="card mb-4">
    <div class="card-header">
        Pencarian Pegawai
    </div>
    <div class="card-body">
        <form action="{{ route('pegawai.index') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="search" class="visually-hidden">Kata Kunci</label>
                <input type="text" class="form-control" id="search" name="search"
                    placeholder="Cari nama, NIP, atau jabatan..." value="{{ request('search') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-dark">Cari</button>
                @if(request('search'))
                <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary ms-2">Reset Pencarian</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        Data Pegawai Tersimpan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Jabatan</th>
                        <th>Tanggal Lahir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop melalui data pegawai yang dikirim dari controller --}}
                    @forelse ($pegawai as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->nip }}</td>
                        <td>{{ $p->jabatan }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d-m-Y') }}</td>
                        {{-- Format tanggal agar lebih mudah dibaca --}}
                        <td>
                            <a href="{{ route('pegawai.show', $p->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('pegawai.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('pegawai.destroy', $p->id) }}" method="POST" class="d-inline">
                                @csrf {{-- Token CSRF untuk keamanan form --}}
                                @method('DELETE') {{-- Memberitahu Laravel bahwa ini adalah permintaan DELETE --}}
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini? Data tidak bisa dikembalikan!')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    {{-- Akan ditampilkan jika tidak ada data pegawai --}}
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data pegawai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endsection