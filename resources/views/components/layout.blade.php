{{-- resources/views/components/layout.blade.php --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name','Sneakerness') }}</title>

  {{-- Bootstrap CSS (single source) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- Bootstrap Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  {{-- Your app CSS/JS (Tailwind/custom) --}}
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-vh-100 d-flex flex-column">

  {{-- NAVBAR --}}
  <nav class="navbar navbar-dark bg-dark sticky-top navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/') }}">
        <i class="bi bi-lightning-fill"></i> Sneakerness
      </a>

      {{-- Toggler shows < lg; at lg+ the offcanvas turns into inline content --}}
      <button class="navbar-toggler" type="button"
              data-bs-toggle="offcanvas" data-bs-target="#mainNavCanvas"
              aria-controls="mainNavCanvas" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      {{-- Offcanvas on small screens; inline at lg+ thanks to .offcanvas-lg --}}
      <div class="offcanvas offcanvas-end offcanvas-lg text-bg-dark" tabindex="-1"
           id="mainNavCanvas" aria-labelledby="mainNavCanvasLabel" data-bs-scroll="true">
        <div class="offcanvas-header d-lg-none">
          <h5 class="offcanvas-title m-0" id="mainNavCanvasLabel">Menu</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link {{ request()->is('tickets*') ? 'active' : '' }}" href="{{ url('/tickets') }}">
                Tickets
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('evenements.*') ? 'active' : '' }}" href="{{ route('evenements.index') }}">
                Events
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('stands*') ? 'active' : '' }}" href="{{ url('/stands') }}">
                Stands
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('info') ? 'active' : '' }}" href="{{ url('/info') }}">
                Info
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">
                Contact
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('privacy') ? 'active' : '' }}" href="{{ url('/privacy') }}">
                Privacy
              </a>
            </li>
          </ul>
        </div>
      </div> {{-- /offcanvas --}}
    </div>
  </nav>

  {{-- MAIN CONTENT --}}
  <main class="flex-grow-1">
    {{ $slot }}
  </main>

  {{-- FOOTER --}}
  <footer class="py-4 border-top bg-body">
    <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center gap-2">
      <small>© {{ date('Y') }} Sneakerness® — Van Nellefabriek, Rotterdam</small>
      <div class="d-flex gap-3">
        <a href="{{ url('/info') }}">Praktische info</a>
        <a href="{{ url('/contact') }}">Contact</a>
        <a href="{{ url('/privacy') }}">Privacy</a>
      </div>
    </div>
  </footer>

  {{-- Bootstrap JS bundle (required for offcanvas) --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
