@extends('layouts.app')

@section('content')
<h1>Selamat Datang di Dashboard Admin!</h1>
<p>Anda telah login sebagai admin. Di sini akan ada ringkasan dan link ke panel Filament.</p>
<a href="{{ url('/admin') }}" class="btn btn-primary">Go to Filament Admin Panel</a>
@endsection