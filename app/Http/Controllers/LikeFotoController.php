<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\LikeFoto;
use Illuminate\Http\Request;

class LikeFotoController extends Controller
{
    // public function add_like($foto_id){
    //     $like = LikeFoto::where('foto_id', $foto_id)->where('user_id', auth()->user()->id)->first();

    //     if ($like) {
    //         $like->delete();
    //         return back();
    //     } else {
    //         LikeFoto::create([
    //             'foto_id' => $foto_id,
    //             'user_id' => auth()->user()->id
    //         ]);
    //         return back();
    //     }
    // }

    public function like(Request $request, Foto $foto) {
        // Pastikan pengguna terotentikasi
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk menyukai foto.');
        }
    
        // Pastikan user_id tidak null
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->back()->with('error', 'User ID tidak tersedia.');
        }
    
        // Cek apakah pengguna sudah menyukai foto ini sebelumnya
        $existingLike = LikeFoto::where('foto_id', $foto->id)
                                ->where('user_id', $userId)
                                ->first();
    
        // Jika sudah ada like, kembalikan dengan pesan
        if ($existingLike) {
            return redirect()->back()->with('error', 'Anda sudah menyukai foto ini sebelumnya.');
        }
    
        // Tambahkan like baru
        $like = new LikeFoto();
        $like->foto_id = $foto->id;
        $like->user_id = $userId;
        $like->save();
    
        return redirect()->back()->with('success', 'Foto disukai!');
    }


    public function unlike(Request $request, Foto $foto) {
        // Lakukan validasi atau cek apakah pengguna sudah login
    
        // Hapus like berdasarkan foto_id dan user_id
        LikeFoto::where('foto_id', $foto->id)
                ->where('user_id', auth()->id())
                ->delete();
    
        // Redirect atau kirimkan respons sesuai kebutuhan
        return back()->with('success', 'Like dihapus!');
    }
}
