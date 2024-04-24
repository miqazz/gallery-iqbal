<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AlbumController extends Controller
{
    public function add_album(){
        $data['title'] = 'Gallery MI - Tambah Album User';
        $data['description'] = 'Aplikasi ini dibuat dengan tujuan menyelesaikan tugas uji kompetensi keahlian di SMKN 2 Bandar Lampung';
        $album = Album::where('user_id',auth()->user()->id)->get();
        return view('add-album', compact('data', 'album'));
    }

    public function post_album(Request $request): RedirectResponse{
        $request->validate([ 
            'nama_album' => 'required',
            'deskripsi' => 'required',
        ]);

        $data = $request->all();
        $data['tanggal_dibuat'] = date('Y-m-d');
        $data['user_id'] = auth()->user()->id;
        Album::create($data);
        return redirect("add-album")->withSuccess('Anda Berhasil Menambahkan Album');
    }

    public function edit_album(Album $album)
    {
        $data['title'] = 'Aplikasi Web Gallery Iqbal - Edit Album User';
        $data['description'] = 'Aplikasi ini dibuat dengan tujuan menyelesaikan tugas uji kompetensi keahlian di SMKN 2 Bandar Lampung';
        // Pastikan pengguna memiliki akses untuk mengedit album
        if ($album->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit album ini.');
        }

        return view('edit-album', compact('data','album'));
    }

    public function update_album(Request $request, Album $album): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'nama_album' => 'required',
            'deskripsi' => 'required',
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);

        // Pastikan pengguna memiliki akses untuk mengedit album
        if ($album->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit album ini.');
        }

        // Update data album
        $album->update($request->all());

        return redirect()->route('album.index')->withSuccess('Album berhasil diperbarui.');
    }

    public function destroy_album(Album $album): RedirectResponse
    {
        // Pastikan pengguna memiliki akses untuk menghapus album
        if ($album->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus album ini.');
        }

        // Hapus album beserta semua fotonya
        $album->foto()->delete();
        $album->delete();

        return redirect()->route('album.index')->withSuccess('Album dan semua fotonya berhasil dihapus.');
    }
}
