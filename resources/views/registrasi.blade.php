@extends('layout')

@section('content')
<div class="container">
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center"><h5>Daftar Akun Baru</h5></div>
                        <form action="post-registrasi" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control" placeholder="isi username anda">
                                @if ($errors->has('username'))
                                    <span class="text-danger">{{ $errors->first('username') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="isi nama lengkap anda">
                                @if ($errors->has('nama_lengkap'))
                                    <span class="text-danger">{{ $errors->first('nama_lengkap') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" placeholder="isi alamat tinggal anda"></textarea>
                                @if ($errors->has('alamat'))
                                    <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="isi email anda">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="isi password anda">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload Foto</label>
                                <input type="file" name="lokasi_file" accept=".jpg, .jpeg, .png" class="form-control">
                                @if ($errors->has('lokasi_file'))
                                    <span class="text-danger">{{ $errors->first('lokasi_file') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection