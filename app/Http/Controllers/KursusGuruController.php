<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;

class KursusGuruController extends Controller
{
public function index()
{
    $allMapel = Mapel::all();

    $mapel = [
        'indo' => $allMapel->where('nama', 'Bahasa Indonesia')->first(),
        'inggris' => $allMapel->where('nama', 'Bahasa Inggris')->first(),
        'mtk' => $allMapel->where('nama', 'Matematika')->first(),
    ];

    $tipe = 'guru';

    return view('guru.kursus', compact('mapel','tipe'));
}
}