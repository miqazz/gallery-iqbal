@extends('layout')

@section('content')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Edit Album</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('album.update', $album->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama_album">Nama Album</label>
                            <input id="nama_album" type="text" class="form-control @error('nama_album') is-invalid @enderror" name="nama_album" value="{{ $album->nama_album }}" required autofocus>

                            @error('nama_album')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" required>{{ $album->deskripsi }}</textarea>

                            @error('deskripsi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Tambahkan input untuk validasi lainnya sesuai kebutuhan  --}}

                        <div class="form-group mb-0 mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
