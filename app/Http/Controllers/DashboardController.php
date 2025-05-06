<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data bisa diambil dari database, contoh nanti ya
        return view('dashboard-admin');
    }
}
