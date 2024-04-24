@extends('layout')

@section('content')'
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

    <h4 class="mt-3">Selamat Datang Admin {{ auth()->user()->nama_lengkap }}</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        @foreach ($user->skip(1) as $item)
            <tr>
                <td>{{ $item['username'] }}</td>
                <td>{{ $item['password'] }}</td>
                <td>{{ $item['nama_lengkap'] }}</td>
                <td>{{ $item['email'] }}</td>
                <td>{{ $item['alamat'] }}</td>
                <td>
                    {{-- <a href="/add-album/{{ $item->id }}" class="btn btn-sm btn-primary">Tambah Foto</a> --}}
                    {{-- <a href="/album/{{ $item->id }}/edit/" class="btn btn-sm btn-warning">Edit Album</a> --}}
                    <a href="#modalHapusAlbum{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#modalHapusAlbum{{ $item->id }}" class="btn btn-sm btn-danger">Hapus User</a>
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
                                    <form id="delete-album-form" action="{{ route('user.destroy', $item->id) }}" method="POST">
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
@endsection