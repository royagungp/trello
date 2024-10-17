<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="{{ csrf_token()}}">
    {{-- $title diambil dari extends ['title' => '...'] --}}
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- icon bar --}}
    {{-- asset() : memanggil file yg ada di folder public --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/naspad1.png') }}">

    {{-- stack : wadah penampung content dinamis namun optional (tidak selalu digunakan) biasanya untuk wadah styling tambahan atau script tambahan --}}
    @stack('style')
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#"><img style="width: 50px; padding-right: 10px"="" src="{{ asset('assets/images/naspad1.png') }}" alt="">NASPAD ROY</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            @if (Auth::check())
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        {{-- Route::is -> mengecek name route yg lg diakses --}}
                        {{-- kalau name route yg lg diakses itu welcome, kasih class active (warna teks item), kalau bukan active ga dimunculin (warna teks abu-abu) --}}
                        <a class="nav-link {{ Route::is('welcome') ? 'active' : '' }}" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        {{-- pemanggilan route pada href :
                            1. path (/)
                            2. name -> {{ route('name_routenya') }} : lebih baik
                        --}}
                        <a class="nav-link {{ Route::is('landing_page') ? 'active' : '' }}" href="{{ route('landing_page') }}">Landing</a>
                    </li>
                    @if(Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('naspads') ? 'active' : '' }}" href="{{ route('naspads') }}">Data naspad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('akun') ? 'active' : '' }}" href="{{ route('akun') }}">Kelola Akun</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>

                </ul>
                <form class="d-flex" role="search" action="" method="GET">
                    {{-- mengaktifkan form di laravel :
                        1. di <form> ada action dan method
                            - GET : ketika form berfungsi untuk search (mencari data)
                            - POST : ketika form berfungsi untuk menambah/mengubah/menghapus data
                            - action : diisi dari web.php (route)
                        2. ada button type submit
                        3. di <input> harus ada name
                    --}}
                    <input class="form-control me-2" type="text" placeholder="Search" aria-label="Search" name="search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            @endif
        </div>
    </nav>

    <div class="container">
        {{-- wadah untuk penampung content yg berbeda ditiap halamannya --}}
        @yield('content-dinamis')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>


    @stack('script')
</body>

</html>
