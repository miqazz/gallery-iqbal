<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\KomentarFotoController;
use App\Http\Controllers\LikeFotoController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\UserController;
use App\Models\Album;
use App\Models\Foto;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'index']);
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('post-login', [UserController::class, 'post_login']);
Route::get('/registrasi', [UserController::class, 'registrasi'])->name('registrasi');
Route::post('post-registrasi', [UserController::class, 'post_registrasi']);
Route::get('signout', [UserController::class, 'signOut'])->name('user.signout');




// Route::group(['middleware' => ['auth', 'checkrole:0,1']], function() {
//     Route::get('/', [RedirectController::class, 'cek']);
// });
Route::middleware(['auth', 'checkrole:1'])->group(function(){
    Route::get('/super-admin', [UserController::class, 'admin'])->name('admin.index');
    Route::delete('/super-admin/{user}',[UserController::class, 'destroy_user'])->name('user.destroy');
});

Route::middleware(['auth', 'checkrole:0'])->group(function(){
    Route::get('/add-album', [AlbumController::class, 'add_album'])->name('album.index');
    Route::post('post-album',[AlbumController::class,'post_album']);
    Route::get('/album/{album}/edit', [AlbumController::class, 'edit_album'])->name('album.edit');
    Route::put('album/{album}', [AlbumController::class, 'update_album'])->name('album.update');
    Route::delete('/album/{album}', [AlbumController::class, 'destroy_album'])->name('album.destroy');
    Route::get('/add-album/{id}',[FotoController::class,'add_foto'])->name('foto.index');
    Route::post('post-foto',[FotoController::class,'post_foto']);
    Route::get('/foto/{foto}/edit', [FotoController::class, 'edit_foto'])->name('foto.edit');
    Route::put('/foto/{foto}', [FotoController::class, 'update_foto'])->name('foto.update');
    Route::delete('foto/{foto}', [FotoController::class, 'destroy_foto'])->name('foto.destroy');
    Route::post('/like/{foto}', [LikeFotoController::class, 'like'])->name('foto.like');
    Route::delete('/unlike/{foto}', [LikeFotoController::class, 'unlike'])->name('foto.unlike');
    Route::post('/fotos/{foto}/comments', [KomentarFotoController::class, 'store_komentar_foto'])->name('komentar.store');
    Route::delete('komentar/{komentarFoto}', [KomentarFotoController::class, 'destroy_komentar_foto'])->name('komentar.destroy');

    Route::get('/user', [UserController::class, 'user_profile'])->name('user.profile');
    Route::put('/profile', [UserController::class, 'update_user'])->name('user.profile.update');
});



