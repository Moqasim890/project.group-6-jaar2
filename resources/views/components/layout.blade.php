<<<<<<< HEAD
{{-- resources/views/components/layout.blade.php --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ config('app.name','Sneakerness') }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<nav class="navbar navbar-dark bg-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/') }}">
      <i class="bi bi-lightning-fill"></i> Sneakerness
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mainNavCanvas"
            aria-controls="mainNavCanvas" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="mainNavCanvas" aria-labelledby="mainNavCanvasLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mainNavCanvasLabel">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ url('/tickets') }}">Tickets</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('evenements.index') }}">Events</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/stands') }}">Stands</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/info') }}">Info</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/privacy') }}">Privacy</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>


  <main class="text-white text-center">
    {{ $slot }}
  </main>

  <footer class="py-4 border-top">
    <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center gap-2">
      <small>© {{ date('Y') }} Sneakerness® — Van Nellefabriek, Rotterdam</small>
      <div class="d-flex gap-3">
        <a href="{{ url('/info') }}">Praktische info</a>
        <a href="{{ url('/contact') }}">Contact</a>
        <a href="{{ url('/privacy') }}">Privacy</a>
      </div>
    </div>
  </footer>
</body>
</html>
=======
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sneakerness') }} — Home</title>
    <meta name="description" content="Sneakerness® Rotterdam — koop tickets per tijdslot of huur een stand.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-image: url('{{ asset('img/Sneaker.webp') }}') !important;
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
</head>

<body>
    <div class="min-vh-100 w-100 d-flex flex-column">
        <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/') }}">
                    <i class="bi bi-circle"></i> Sneakerness
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="mainNav" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/tickets') }}">Tickets</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/verkopers') }}">Verkopers</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/info') }}">login</a></li>
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item ms-lg-2"><a class="btn btn-outline-dark"
                                        href="{{ url('/dashboard') }}">Dashboard</a></li>
                            @else
                                <li class="nav-item ms-lg-2"><a class="btn btn-outline-secondary"
                                        href="{{ route('login') }}">Log in</a></li>
                                @if (Route::has('register'))
                                    <li class="nav-item ms-lg-2"><a class="btn btn-dark"
                                            href="{{ route('register') }}">Registreren</a></li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="flex-grow-1 container my-5 d-flex flex-column justify-content-center align-items-center">
            {{ $slot }}
        </main>

        <footer class="py-4 border-top bg-white mt-5">
            <div class="container d-flex flex-column flex-lg-row justify-content-between gap-">
                <small class="muted">© {{ date('Y') }} Sneakerness® — Van Nellefabriek, Rotterdam</small>
                <div class="d-flex gap-3">
                    <a class="btn btn-secondary" href="{{ url('/info') }}">Praktische info</a>
                    <a class="btn btn-secondary" href="{{ url('/contact') }}">Contact</a>
                    <a class="btn btn-secondary" href="{{ url('/privacy') }}">Privacy</a>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
>>>>>>> 3a465e1e2ff37ef92f393aa14bb154825221052b
