<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="title" content="{{ $data['title'] }}">
    <meta name="description" content="{{ $data['description'] }}">
    <title>{{ $data['title'] }}</title>
    <link href="{{ asset('bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-navbar">
        <div class="container">
            <a href="/" class="navbar-brand d-flex"><img src="{{ asset('logo2.png') }}" style="height: 50px; margin-right: 5px"><h4><span class="d-block" style="font-size: 25px">Gallery</span><span class="d-block" style="font-size: 16px">Moch. Iqbal Az-zahir</span></h4></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto ">
                    <li class="nav-item">
                        <a href="/" aria-current="page" class="nav-link {{ request()->segment(1) == '' || request()->segment(1) == '/' ? 'active' : ''; }}">Home</a>
                    </li>
                    @guest
                    <li class="nav-item ">
                        <a href="login" aria-current="page" class="nav-link {{ request()->segment(1) == 'login' ? 'active' : ''; }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="registrasi" aria-current="page" class="nav-link {{ request()->segment(1) == 'registrasi' ? 'active' : ''; }}">Registrasi</a>
                    </li>
                    @else
                    @if ((auth()->user()->is_admin === 1))
                    <li class="nav-item">
                        <a href="/super-admin" class="nav-link {{ request()->segment(1) == 'super-admin' ? 'active' : '' }}">Super Admin</a>
                    </li>
                    @else
                        <li class="nav-item">
                            <a href="/add-album" class="nav-link {{ request()->segment(1) == 'add-album' ? 'active' : '' }}">Daftar Album</a>
                        </li>
                    @endif
                    {{-- <li class="nav-item">
                        <a href="{{ route('user.signout') }}"  class="nav-link btn bg-danger text-white">Logout</a>
                    </li> --}}
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{ asset('foto').'/'.auth()->user()->lokasi_file }}" style="width: 30px; border-radius: 50%">
                            {{ Auth::user()->nama_lengkap }}
                        </a>
                  
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a href="{{ route('user.profile') }}" class="dropdown-item">Profile</a>
                            <a class="dropdown-item" href="{{ route('user.signout') }}">
                                {{ __('Logout') }}
                            </a>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <script src="{{ asset('bootstrap.bundle.min.js') }}"></script>
</body>
</html>