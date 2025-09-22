<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ config('app.name','Sneakerness') }}</title>

  {{-- Bootstrap CSS + icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  {{-- Your assets via Vite --}}
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100">

  <nav class="navbar navbar-dark bg-dark sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/') }}">
        <i class="bi bi-lightning-fill"></i> Sneakerness
      </a>

      <button class="navbar-toggler" type="button"
              data-bs-toggle="offcanvas" data-bs-target="#mainNavCanvas"
              aria-controls="mainNavCanvas" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="mainNavCanvas" aria-labelledby="mainNavCanvasLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="mainNavCanvasLabel">Menu</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
          {{-- SINGLE ul (removed the accidental nested <ul>) --}}
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{ url('/tickets') }}">Tickets</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('stands.index') }}">Stands</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('evenements.index') }}">Evenementen</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/info') }}">Info</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/privacy') }}">Privacy</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  {{-- Make main fill available height so footer stays at the bottom --}}
  <main class="flex-grow-1">
    {{ $slot }}
  </main>

  <footer class="py-4 border-top bg-dark text-white-50">
    <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center gap-2">
      <small>© {{ date('Y') }} Sneakerness® — Van Nellefabriek, Rotterdam</small>
      <div class="d-flex gap-3">
        <a class="link-light link-underline-opacity-0 link-underline-opacity-50-hover" href="{{ url('/info') }}">Praktische info</a>
        <a class="link-light link-underline-opacity-0 link-underline-opacity-50-hover" href="{{ url('/contact') }}">Contact</a>
        <a class="link-light link-underline-opacity-0 link-underline-opacity-50-hover" href="{{ url('/privacy') }}">Privacy</a>
      </div>
    </div>
  </footer>

  {{-- Bootstrap JS bundle (required for offcanvas/toggler) --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
