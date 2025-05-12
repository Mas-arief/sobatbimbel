<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;

class GuruController extends Controller
{
    // Method untuk mengupdate data guru
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        
        $guru->update([
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempatLahir,
            'tanggal_lahir' => $request->tanggalLahir,
            'jk' => $request->jenisKelamin,
            'mapel' => $request->guruMapel,
            'nohp' => $request->nohp,
            'email' => $request->email,
        ]);
        
        return redirect()->route('admin.profile_guru')->with('success', 'Data guru berhasil diperbarui.');
    }
}
