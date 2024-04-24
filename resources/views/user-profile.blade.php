@extends('layout')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Profile') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lokasi_file" class="form-label">Foto Profile: </label>
                                    <input id="lokasi_file" type="file" class="form-control @error('lokasi_file') is-invalid @enderror" name="lokasi_file" value="{{ old('lokasi_file') }}"  autocomplete="lokasi_file">
                                    @error('lokasi_file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <img src="{{ asset('foto').'/'.auth()->user()->lokasi_file }}" style="width:80px;margin-top: 10px;" alt="{{ asset('foto').'/'.auth()->user()->lokasi_file }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input class="form-control" type="text" id="username" name="username" value="{{ auth()->user()->username }}" autofocus="" readonly>
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap:</label>
                            <input class="form-control" type="text" id="nama_lengkap" name="nama_lengkap" value="{{ auth()->user()->nama_lengkap }}" autofocus="">
                            @error('nama_lengkap')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input class="form-control" type="text" id="email" name="email" value="{{ auth()->user()->email }}" autofocus="" readonly>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat:</label>
                            <input class="form-control" type="text" id="alamat" name="alamat" value="{{ auth()->user()->alamat }}" autofocus="">
                            @error('alamat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input class="form-control" type="password" id="password" name="password" autofocus="" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="whatsapp" class="form-label">WhatsApp:</label>
                            <input class="form-control" type="number" id="whatsapp" name="whatsapp" value="{{ auth()->user()->whatsapp }}" autofocus="">
                            @error('whatsapp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 offset-md-5">
                                <button type="submit" class="btn btn-primary">{{ __('Upload Profile') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
