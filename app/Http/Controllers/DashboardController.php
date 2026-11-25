<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Untuk sementara mengembalikan view kosong
        return view('dashboard');
    }
}