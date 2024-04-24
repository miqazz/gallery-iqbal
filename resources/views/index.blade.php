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

    <div class="mt-3">
        {!! auth()->check() ? 'Selamat Datang, '.auth()->user()->nama_lengkap.' di aplikasi galeri foto <br> <a href="add-album" class="btn btn-sm btn-primary">Tambah Album</a>' : 'Anda belum login, silahkan login terlebih dahulu'!!}
    </div>

    <div class="row mt-5">

        @foreach ($fotos as $foto)
            <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                    <div class="card bg-dark text-white">
                        <img src="{{ asset('foto').'/'.$foto->lokasi_file }}" class="card-img-top align-self-center object-fit-contain border rounded " alt="{{ $foto->lokasi_file }}" style="height:300px;">
                        <div class="card-img-overlay card-bg">
                            <h5 class="card-title">{{ $foto->judul_foto }}</h5>
                            {{-- <p class="card-text">{{ $foto->deskripsi_foto }}</p> --}}
                            <div style="margin-top:150px;">
                            @if ($foto->isLikedBy(auth()->id())) 
                                <form action="{{ route('foto.unlike', $foto) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger "><i class="fas fa-heart"></i> {{ $likeCounts[$foto->id] }} Unlike</button>
                                </form>
                            @else
                                <form action="{{ route('foto.like', $foto) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-heart"></i> {{ $likeCounts[$foto->id] }} Like</button>
                                </form>
                            @endif
                            </div>

                            {{-- Tambahkan tombol atau ikon untuk membuka modal --}}
                            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $foto->id }}">
                                Tambah Komentar
                            </button>
                            {{-- Modal untuk komentar  --}}
                            <div class="modal fade" id="exampleModal{{ $foto->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header text-dark">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ $foto->user->nama_lengkap }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-dark">
                                            {{-- Tambahkan keterangan ke dalam modal --}}
                                            <h5 class="card-title">{{ $foto->judul_foto }}</h5>
                                            <p class="card-text">{{ $foto->deskripsi_foto }}</p>

                                            {{-- Tambahkan gambar ke dalam modal  --}}
                                            <img src="{{ asset('foto').'/'.$foto->lokasi_file }}" class="img-fluid mb-3" alt="{{ $foto->lokasi_file }}">
                                            
                                            {{-- Formulir untuk menulis komentar  --}}
                                            <form action="{{ route('komentar.store', $foto->id) }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    {{-- <label for="comment" class="form-label">Komentar</label>
                                                    <textarea class="form-control" id="comment" name="isi_komentar" rows="3"></textarea> --}}
                                                    <label for="comment" class="form-label">Komentar</label>
                                                    <input type="hidden" name="foto_id" value="{{ $foto->id }}">
                                                    <textarea class="form-control" name="isi_komentar" placeholder="Tulis komentar Anda..." rows="3" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                                            </form>
                                            <ul class="list-group mt-3">
                                                @foreach ($foto->komentar_foto as $komentar)
                                                    <li class="list-group-item">
                                                        {{ $komentar->user->nama_lengkap }}: {{ $komentar->isi_komentar }}
                                                        
                                                        @if ($komentar->user_id === auth()->id())
                                                            <form action="{{ route('komentar.destroy', $komentar) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm float-end">Hapus</button>
                                                            </form>
                                                        @endif 
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        @endforeach
    </div>
</div>
    <!-- footer -->
    <div class="pt-3 pb-2 mt-3" id="footer">
        <div class="container">
          <div class="row">
            <div class="col-lg-6">
              <h1>Moch. Iqbal Az-zahir</h1>
              <p>Terimakasih telah berkunjung ke halaman web saya.</p>
            </div>
          <hr>
            <div class="col-md-12">
              <div class="col-md-12 text-center">
                <p>
                  ©Copyright 2024 <span>Gallery Moch. Iqbal Az-zahir</span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
