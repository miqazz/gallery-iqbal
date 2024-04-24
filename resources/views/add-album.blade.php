@extends('layout')

@section('content')
<div class="container">
    <div class="mt-3">
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
    </div>

    <h4 class="mt-3">Daftar Data Album {{ auth()->user()->nama_lengkap }}</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th class="text-center text-white bg-dark">Nama Album</th>
                <th class="text-center text-white bg-dark">Deskripsi</th>
                <th class="text-center text-white bg-dark">Aksi</th>
            </tr>
        </thead>
        @foreach ($album as $item)
            <tr>
                <td>{{ $item['nama_album'] }}</td>
                <td>{{ $item['deskripsi'] }}</td>
                <td>
                    <a href="/add-album/{{ $item->id }}" class="btn btn-sm btn-primary">Tambah Foto</a>
                    <a href="/album/{{ $item->id }}/edit/" class="btn btn-sm btn-warning">Edit Album</a>
                    <a href="#modalHapusAlbum{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#modalHapusAlbum{{ $item->id }}" class="btn btn-sm btn-danger">Hapus Album</a>
                    {{-- <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusAlbum{{ $item->id }}">Hapus Album</button> --}}
                    <!-- Modal untuk menghapus -->
                    <div class="modal fade" id="modalHapusAlbum{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Yakin Mau Menghapus Albumnya nih?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="delete-album-form" action="{{ route('album.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                
                                        <div class="form-group mb-0">
                                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
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
    <form action="post-album" method="post">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Album</label>
            <input type="text" name="nama_album" class="form-control" placeholder="isi nama album anda">
            @if ($errors->has('nama_album'))
                <span class="text-danger">{{ $errors->first('nama_album') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi Album</label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="isi deskripsi album anda"></textarea>
            @if ($errors->has('deskripsi'))
                <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
            @endif
        </div>
        
        <button class="btn btn-primary">Tambah</button>
    </form>
</div>
@endsection