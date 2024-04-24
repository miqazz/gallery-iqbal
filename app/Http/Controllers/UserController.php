<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\User;
use App\Models\LikeFoto;
use Illuminate\Support\Str;
use App\Models\KomentarFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index() {
        $data['title'] = 'Gallery MI';
        $data['description'] = 'Aplikasi ini dibuat dengan tujuan menyelesaikan tugas uji kompetensi keahlian di SMKN 2 Bandar Lampung';

        $fotos = Foto::all();
        $likeCounts = []; // Inisialisasi array untuk menyimpan jumlah like untuk setiap foto

        $comments = KomentarFoto::with('user','foto')->get();
        
        foreach ($fotos as $foto) {
            $likeCounts[$foto->id] = LikeFoto::where('foto_id', $foto->id)->count();
            // Menghitung jumlah like untuk setiap foto dan menyimpannya dalam array $likeCounts
        }
        return view('index', compact('data', 'fotos', 'likeCounts', 'comments'));
    }

    public function registrasi(){
        $data['title'] = 'Gallery MI - Registrasi User';
        $data['description'] = 'Aplikasi ini dibuat dengan tujuan menyelesaikan tugas uji kompetensi keahlian di SMKN 2 Bandar Lampung';
        
        return view('registrasi', compact('data'));
    }

    public function login(){
        $data['title'] = 'Gallery MI - Login User';
        $data['description'] = 'Aplikasi ini dibuat dengan tujuan menyelesaikan tugas uji kompetensi keahlian di SMKN 2 Bandar Lampung';
        
        return view('login', compact('data'));
    }

    public function post_registrasi(Request $request): RedirectResponse{
        $request->validate([
            'username' => 'required|unique:users',
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3',
            'lokasi_file' => 'required'
        ]);

        $data = $request->all();
        $data['is_admin'] = '0';
        $image = $data['lokasi_file'];
        $data['lokasi_file'] = str()->slug($data['username']).'.'.$image->extension();
        $image->move('foto',$data['lokasi_file']);

        User::create($data);
        // $check = $this->create($data);

        return redirect("login")->withSuccess('Anda Berhasil Melakukan Registrasi');
    }

    public function post_login(Request $request): RedirectResponse{
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required|min:3'
        ]);

        if (auth()->attempt($credentials)) {

            // buat ulang session login
            $request->session()->regenerate();

            if (auth()->user()->is_admin === 1) {
                // jika user superadmin
                return redirect()->intended('/super-admin');
            } else {
                // jika user pegawai
                return redirect()->intended('/');
            }
        }

        // jika username atau password salah
        // kirimkan session error
        return back()->with('error', 'username atau password salah');
    }

    public function admin(){
        $data['title'] = 'Gallery MI - SuperAdmin';
        $data['description'] = 'Aplikasi ini dibuat dengan tujuan menyelesaikan tugas uji kompetensi keahlian di SMKN 2 Bandar Lampung';

        $user = User::all();
        return view('list-user', compact('data','user'));
    }
    public function destroy_user(User $user): RedirectResponse
    {
        // Pastikan pengguna memiliki akses untuk menghapus album
        // if ($user->user_id !== Auth::id()) {
        //     return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus album ini.');
        // }

        // Hapus user beserta semua foto, album, like dan komentarnya
        $user->like_foto()->delete();
        $user->komentar_foto()->delete();
        $user->album()->delete();
        $user->foto()->delete();
        $user->delete();

        return redirect()->route('admin.index')->withSuccess('User dan semua foto, album, like dan komentarnya berhasil dihapus.');
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }

    public function create(array $data){
        return User::create([
            'username' => $data['username'],
            'nama_lengkap' => $data['nama_lengkap'],
            'alamat' => $data['alamat'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'whatsapp' => $data['whatsapp']
        ]);
    }

    public function user_profile(){
        $data['title'] = 'Aplikasi Web Gallery Iqbal - Profile User';
        $data['description'] = 'Aplikasi ini dibuat dengan tujuan menyelesaikan tugas uji kompetensi keahlian di SMKN 2 Bandar Lampung';

        $user = auth()->user();
        return view('user-profile',compact('data','user'));
    }


//     public function update_user(Request $request, User $user){
//         // $request->validate([
//         //     'nama_lengkap' => 'required',
//         //     'alamat' => 'required',
//         //     'password' => 'required_with:password|same:password',
//         //     'whatsapp' => 'required',
//         //     'lokasi_file' => 'image', // Sesuaikan dengan kebutuhan
//         // ]);
//         // // $input = $request->all();
//         // $user->nama_lengkap = $request->nama_lengkap;
//         // $user->alamat = $request->alamat;
//         // $user->password = $request->password;
//         // $user->whatsapp = $request->whatsapp;
          
//         // // if ($request->hasFile('lokasi_file')) {
//         // //     $avatarName = time().'.'.$request->lokasi_file->getClientOriginalExtension();
//         // //     $request->lokasi_file->move(public_path('foto/'), $avatarName);
  
//         // //     $input['lokasi_file'] = $avatarName;
        
//         // // } else {
//         // //     unset($input['lokasi_file']);
//         // // }
  
//         // // if ($request->filled('password')) {
//         // //     $input['password'] = Hash::make($input['password']);
//         // // } else {
//         // //     unset($input['password']);
//         // // }
  
//         // if ($request->hasFile('lokasi_file')) {
//         //     $lokasi_file = $request->file('lokasi_file');
//         //     $lokasi_file_name = Str::slug($request->username) . '_' . time() . '.' . $lokasi_file->getClientOriginalExtension();
//         //     $lokasi_file->move(public_path('foto'), $lokasi_file_name);
    
//         //     // Hapus file gambar lama jika ada
//         //     if ($user->lokasi_file && file_exists(public_path('foto/' . $user->lokasi_file))) {
//         //         unlink(public_path('foto/' . $user->lokasi_file));
//         //     }
    
//         //     // Simpan lokasi file gambar yang baru
//         //     $user->lokasi_file = $lokasi_file_name;
//         // }
    
//         // // Simpan perubahan data foto
//         // $user->update();

//         // $user = User::findOrFail($id); // Mendapatkan pengguna yang ingin diubah berdasarkan ID

// $request->validate([
//     'username' => 'required',
//     'email' => 'required',
//     'nama_lengkap' => 'required',
//     'alamat' => 'required',
//     'password' => 'required_with:password|same:password',
//     'whatsapp' => 'required',
//     'lokasi_file' => 'image', // Pastikan nama input pada formulir adalah 'lokasi_file'
// ]);


// $user->username = $request->username;
// $user->username = $request->email;
// $user->nama_lengkap = $request->nama_lengkap;
// $user->alamat = $request->alamat;
// $user->password = $request->password;
// $user->whatsapp = $request->whatsapp;

// if ($request->hasFile('lokasi_file') && $request->file('lokasi_file')->isValid()) {
//     $lokasi_file = $request->file('lokasi_file');
//     $lokasi_file_name = Str::slug($request->username) . '_' . time() . '.' . $lokasi_file->getClientOriginalExtension();
//     $lokasi_file->move(public_path('foto'), $lokasi_file_name);

//     // Hapus file gambar lama jika ada
//     if ($user->lokasi_file && file_exists(public_path('foto/' . $user->lokasi_file))) {
//         unlink(public_path('foto/' . $user->lokasi_file));
//     }

//     // Simpan lokasi file gambar yang baru
//     $user->lokasi_file = $lokasi_file_name;
// }

// // Simpan perubahan data foto
// $user->save();
    
//         return back()->with('success', 'Profile updated successfully.');
//     }

public function update_user(Request $request){
    $request->validate([
        'nama_lengkap' => 'required',
        'alamat' => 'required',
        'password' => 'required_with:password|same:password',
        'whatsapp' => 'required',
        'lokasi_file' => 'image', // Sesuaikan dengan kebutuhan
    ]);

    $user = auth()->user();

    $input = $request->only('nama_lengkap', 'alamat', 'password', 'whatsapp');

    if ($request->hasFile('lokasi_file') && $request->file('lokasi_file')->isValid()) {
        $lokasi_file = $request->file('lokasi_file');
        $lokasi_file_name = Str::slug($user->username) . '_' . time() . '.' . $lokasi_file->getClientOriginalExtension();
        $lokasi_file->move(public_path('foto'), $lokasi_file_name);

        // Hapus file gambar lama jika ada
        if ($user->lokasi_file && file_exists(public_path('foto/' . $user->lokasi_file))) {
            unlink(public_path('foto/' . $user->lokasi_file));
        }

        // Simpan lokasi file gambar yang baru
        $input['lokasi_file'] = $lokasi_file_name;
    }

    $user->update($input);

    return back()->with('success', 'Profile updated successfully.');
}




}
