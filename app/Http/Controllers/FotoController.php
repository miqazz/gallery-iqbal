<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Album;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class FotoController extends Controller
{
    public function add_foto(){
        $data['title'] = 'Aplikasi Web Gallery Iqbal - Tambah Foto Album User';
        $data['description'] = 'Aplikasi ini dibuat dengan tujuan menyelesaikan tugas uji kompetensi keahlian di SMKN 2 Bandar Lampung';
        $album = Album::where([['user_id',auth()->user()->id],['id',request()->segment(2)]])->with('foto')->first();
        return view('add-foto', compact('data','album'));   
    }

    public function post_foto(Request $request): RedirectResponse{
        $request->validate([ 
            'judul_foto' => 'required',
            'deskripsi_foto' => 'required',
            'lokasi_file' => 'required',
            'album_id' => 'required'
        ]);

        $data = $request->all();
        $data['tanggal_unggah'] = date('Y-m-d');
        $data['user_id'] = auth()->user()->id;

        $image = $data['lokasi_file'];
        $data['lokasi_file'] = str()->slug($data['judul_foto']).'.'.$image->extension();
        $image->move('foto',$data['lokasi_file']);
        Foto::create($data);
        return redirect('add-album/'.$data['album_id'])->withSuccess('Selamat Foto Telah Di Upload');
    }

    public function edit_foto(Foto $foto)
    {
        // Pastikan pengguna memiliki akses untuk mengedit foto
        $data['title'] = 'Aplikasi Web Gallery Iqbal - Edit Foto User';
        $data['description'] = 'Aplikasi ini dibuat dengan tujuan menyelesaikan tugas uji kompetensi keahlian di SMKN 2 Bandar Lampung';
        if ($foto->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit foto ini.');
        }

        return view('edit-foto', compact('foto','data'));
    }

    // public function update_foto(Request $request, Foto $foto): RedirectResponse
    // {
    //     // Validasi input
    //     $request->validate([
    //         'judul_foto' => 'required',
    //         'lokasi_file' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg',
    //         'deskripsi_foto' => 'required',
    //         // Tambahkan validasi lainnya sesuai kebutuhan
    //     ]);

    //     // Pastikan pengguna memiliki akses untuk mengedit foto
    //     if ($foto->user_id !== Auth::id()) {
    //         return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit foto ini.');
    //     }

    //     // Update data foto
    //     $foto->update($request->all());

    //     return redirect()->route('album.index', $foto)->withSuccess('Foto berhasil diperbarui.');
    // }

    public function update_foto(Request $request, Foto $foto): RedirectResponse
    {
    // Validasi input
    $request->validate([
        'judul_foto' => 'required|unique:fotos,judul_foto,'.$foto->id,
        'lokasi_file' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg',
        'deskripsi_foto' => 'required',
        // Tambahkan validasi lainnya sesuai kebutuhan
    ]);

    // Pastikan pengguna memiliki akses untuk mengedit foto
    if ($foto->user_id !== Auth::id()) {
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit foto ini.');
    }

    // Simpan judul foto sebelum diubah untuk penanganan file gambar
    $oldJudulFoto = $foto->judul_foto;

    // Perbarui data foto
    $foto->judul_foto = $request->judul_foto;
    $foto->deskripsi_foto = $request->deskripsi_foto;

    // Jika ada file gambar yang dikirim
    if ($request->hasFile('lokasi_file')) {
        $lokasi_file = $request->file('lokasi_file');
        $lokasi_file_name = Str::slug($request->judul_foto) . '_' . time() . '.' . $lokasi_file->getClientOriginalExtension();
        $lokasi_file->move(public_path('foto'), $lokasi_file_name);

        // Hapus file gambar lama jika ada
        if ($foto->lokasi_file && file_exists(public_path('foto/' . $foto->lokasi_file))) {
            unlink(public_path('foto/' . $foto->lokasi_file));
        }

        // Simpan lokasi file gambar yang baru
        $foto->lokasi_file = $lokasi_file_name;
    }

    // Simpan perubahan data foto
    $foto->save();

    // Redirect dengan pesan sukses
    return redirect()->route('album.index', $foto->album_id)->withSuccess('Foto berhasil diperbarui.');
    }


    public function destroy_foto(Foto $foto): RedirectResponse
    {
        // Pastikan pengguna memiliki akses untuk menghapus foto
        if ($foto->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus foto ini.');
        }

        // Hapus foto dari sistem
        $foto->delete();

        return redirect()->route('album.index')->withSuccess('Foto berhasil dihapus.');
    }
}
