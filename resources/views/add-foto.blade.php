@extends('layout')

@section('content')
<div class="container pt-3">
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="mt-3">
        <h4>Daftar Data Foto Album {{ $album['nama_album'] }}</h4>
        <p>{{ $album['deskripsi'] }}</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center text-white bg-dark">Gambar</th>
                    <th class="text-center text-white bg-dark">Judul Foto dan Deskripsi</th>
                    <th class="text-center text-white bg-dark">Aksi</th>
                </tr>
            </thead>
            @foreach ($album['foto'] as $item)
                <tr>
                    <td style="width:170px"><img src="{{ asset('foto').'/'.$item['lokasi_file'] }}" style="width: 150px" alt=""></td>
                    <td>
                        <h6 class="fw-bold">{{ $item['judul_foto'] }}</h6>
                        <p>{{ $item['deskripsi_foto'] }}</p>
                    </td>
                    <td>
                        <a href="/add-album" class="btn btn-sm btn-primary">Kembali Ke Album</a>
                        <a href="/foto/{{ $item->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                        <a href="#modalHapusFoto{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#modalHapusFoto{{ $item->id }}" class="btn btn-sm btn-danger">Hapus Foto</a>
                        {{-- <button class="btn btn-sm btn-danger" data-bs-toogle="modal" data-bs-target="#modalHapusFoto{{ $item->id }}">Hapus</button> --}}
                        <!-- Modal untuk menghapus -->
                        <div class="modal fade" id="modalHapusFoto{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Yakin Mau Menghapus Fotonya nih?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="delete-album-form" action="{{ route('foto.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                    
                                            <div class="form-group mb-0">
                                                <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        <hr>
        <form action="/post-foto" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Judul Foto</label>
                <input type="text" name="judul_foto" class="form-control" placeholder="isi judul foto anda">
                @if ($errors->has('judul_foto'))
                    <span class="text-danger">{{ $errors->first('judul_foto') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi Foto</label>
                <textarea name="deskripsi_foto" class="form-control" rows="3" placeholder="isi deskripsi foto album anda"></textarea>
                @if ($errors->has('deskripsi_foto'))
                    <span class="text-danger">{{ $errors->first('deskripsi_foto') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Foto</label>
                <input type="file" name="lokasi_file" accept=".jpg, .jpeg, .png" class="form-control">
                @if ($errors->has('lokasi_file'))
                    <span class="text-danger">{{ $errors->first('lokasi_file') }}</span>
                @endif
            </div>
            <input type="hidden" name="album_id" value="{{ $album['id'] }}">
            <button class="btn btn-primary" type="submit">Tambah</button>
        </form>
    </div>
</div>
@endsection