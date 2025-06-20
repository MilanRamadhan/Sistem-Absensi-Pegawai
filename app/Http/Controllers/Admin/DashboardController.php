<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Anda bisa mengambil data ringkasan di sini jika diperlukan
        // Contoh: total pegawai, total izin pending, dll.

        return view('admin.dashboard'); // Mengarahkan ke view admin/dashboard.blade.php
    }
}