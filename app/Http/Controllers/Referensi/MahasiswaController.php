<?php

namespace App\Http\Controllers\Referensi;

use App\Http\Controllers\Controller;
use App\Models\Referensi\Mahasiswa;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    // Tampilkan semua mahasiswa
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('Mahasiswa.index', compact('mahasiswa'));
    }

    // Form tambah mahasiswa
    public function create()
    {
        return view('Mahasiswa.create');
    }

    // Simpan data mahasiswa baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswa',
            'jurusan' => 'required',
            'email' => 'required|email|unique:mahasiswa',
        ]);

        Mahasiswa::create($request->all());

        return redirect()->route('Daftar mahasiswa')
            ->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    // Tampilkan detail mahasiswa
    public function show(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    // Form edit mahasiswa
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('Mahasiswa.edit', compact('mahasiswa'));
    }

    // Update data mahasiswa
public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'nama' => 'required',
        'nim' => 'required|unique:mahasiswa,nim,'.$id, // Memastikan NIM unik kecuali untuk mahasiswa yang sedang diupdate
        'jurusan' => 'required',
        'email' => 'required|email|unique:mahasiswa,email,'.$id, // Memastikan email unik kecuali untuk mahasiswa yang sedang diupdate
    ]);

    // Temukan mahasiswa berdasarkan ID
    $mahasiswa = Mahasiswa::findOrFail($id);

    // Update data mahasiswa
    $mahasiswa->update($request->all());

    // Redirect setelah update dengan pesan sukses
    return redirect()->route('Daftar mahasiswa')
        ->with('success', 'Mahasiswa berhasil diperbarui.');
}



    // Hapus mahasiswa
    public function destroy($id)
    {
        // Temukan mahasiswa berdasarkan ID
        $mahasiswa = Mahasiswa::findOrFail($id);

        // Hapus mahasiswa
        $mahasiswa->delete();

        // Redirect setelah penghapusan dengan pesan sukses
        return redirect()->route('Daftar mahasiswa')->with('success', 'Mahasiswa berhasil dihapus!');
    }
}
