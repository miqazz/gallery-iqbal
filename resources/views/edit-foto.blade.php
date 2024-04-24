@extends('layout')

@section('content')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Edit Foto</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('foto.update', $foto) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="judul_foto">Judul Foto</label>
                            <input id="judul_foto" type="text" class="form-control @error('judul_foto') is-invalid @enderror" name="judul_foto" value="{{ old('judul_foto', $foto->judul_foto) }}" required autofocus>

                            @error('judul_foto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="deskripsi_foto">Deskripsi Foto</label>
                            <textarea id="deskripsi_foto" class="form-control @error('deskripsi_foto') is-invalid @enderror" name="deskripsi_foto" required>{{ old('deskripsi_foto', $foto->deskripsi_foto) }}</textarea>

                            @error('deskripsi_foto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="lokasi_file">Ubah Foto</label>
                            <input id="lokasi_file" type="file" class="form-control @error('lokasi_file') is-invalid @enderror" name="lokasi_file" accept="image/jpeg,image/png,image/jpg">

                            @error('lokasi_file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0 mt-3">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
