<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name','Sneakerness') }} — Home</title>
  <meta name="description" content="Sneakerness® Rotterdam — koop tickets per tijdslot of huur een stand.">




 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
      body {
     background-image: url('{{ asset('img/Sneaker.webp') }}') !important;
      background-size: cover;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-position: center;
      }
</style>
<body>
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
              <li class="nav-item ms-lg-2"><a class="btn btn-outline-dark" href="{{ url('/dashboard') }}">Dashboard</a></li>
            @else
              <li class="nav-item ms-lg-2"><a class="btn btn-outline-secondary" href="{{ route('login') }}">Log in</a></li>
              @if (Route::has('register'))
                <li class="nav-item ms-lg-2"><a class="btn btn-dark" href="{{ route('register') }}">Registreren</a></li>
              @endif
            @endauth
          @endif
        </ul>
      </div>
    </div>
  </nav>


    {{ $slot }}

  <footer class="py-4 border-top bg-white">
    <div class="container d-flex flex-column flex-lg-row justify-content-between gap-2">
      <small class="muted">© {{ date('Y') }} Sneakerness® — Van Nellefabriek, Rotterdam</small>
      <div class="d-flex gap-3">
        <a class="btn btn-secondary" href="{{ url('/info') }}">Praktische info</a>
        <a class="btn btn-secondary" href="{{ url('/contact') }}">Contact</a>
        <a class="btn btn-secondary" href="{{ url('/privacy') }}">Privacy</a>
      </div>
    </div>
  </footer>

</body>
</html>
