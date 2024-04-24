<?php

namespace App\Http\Controllers;

use App\Models\KomentarFoto;
use Illuminate\Http\Request;

class KomentarFotoController extends Controller
{
    public function store_komentar_foto(Request $request)
    {
        // // Validasi input
        // $request->validate([
        //     'isi_komentar' => 'required|string|max:255', // Ubah 'comment' menjadi 'isi_komentar'
        // ]);

        // // Buat komentar baru
        // $comment = new KomentarFoto();
        // $comment->foto_id = $foto->id; // Set ID foto
        // $comment->user_id = auth()->id(); // Set ID pengguna yang sedang login
        // $comment->isi_komentar = $request->isi_komentar; // Ubah menjadi isi_komentar
        // // $comment->tanggal_komentar = Carbon::now(); // Atur nilai tanggal_komentar sekarang
        // $comment->save();

        // return redirect()->back()->with('success', 'Komentar berhasil disimpan.');
    

        // Validasi Input
        $request->validate([
            'isi_komentar' => 'required|string|max:255',
            'foto_id' => 'required|exists:fotos,id',
        ]);

        // Buat Komentar Baru
        $komentar = new KomentarFoto();
        $komentar->user_id = auth()->id();
        $komentar->foto_id = $request->foto_id;
        $komentar->isi_komentar = $request->isi_komentar;
        $komentar->save();

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function destroy_komentar_foto(KomentarFoto $komentarFoto)
    {
        // $komentarFoto->deleteKomentar();
        // return redirect()->back()->with('success', 'Komentar berhasil dihapus.');

        if ($komentarFoto->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini.');
        }

        $komentarFoto->deleteKomentar();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}
