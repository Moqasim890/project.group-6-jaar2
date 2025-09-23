<x-layout>
<<<<<<< HEAD

  {{-- HERO SECTION --}}
  <section class="pt-3 pb-5">
    <div class="container">
      <div class="row g-4 align-items-stretch">

        {{-- Hero Text --}}
        <div class="col-lg-7">
          <div class="glass p-4 p-lg-5 h-100">
            <span class="badge badge-neon mb-2">Van Nellefabriek • Rotterdam • November</span>
            <h1 class="display-6 fw-semibold mb-2 text-white">De grootste sneaker-community van Europa komt samen.</h1>
            <p class="lead text-light mb-4">
=======
  {{-- HERO --}}
  <section class="py-5" style="background: rgba(255,255,255,0.85); border-radius: 2rem; margin-top: 2rem;">
    <div class="container">
      <div class="row g-4 align-items-stretch">
        <div class="col-lg-7">
          <div class="hero p-4 p-lg-5 h-100">
            <span class="badge text-bg-danger mb-2">Van Nellefabriek • Rotterdam • November</span>
            <h1 class="display-6 fw-semibold mb-2">De grootste sneaker-community van Europa komt samen.</h1>
            <p class="lead muted mb-4">
>>>>>>> 3a465e1e2ff37ef92f393aa14bb154825221052b
              Art • Sport • Fashion • Muziek • <strong>Sneakers</strong>. Koop tickets per tijdslot — hoe eerder je binnen
              bent, hoe groter de kans op je grails.
            </p>
            <div class="d-flex gap-2 flex-wrap">
<<<<<<< HEAD
              <a href="{{ url('/tickets') }}" class="btn btn-neon btn-lg shadow">
                <i class="bi bi-ticket-perforated me-1"></i> Tickets kopen
              </a>
              <a href="{{ url('/verkopers/inschrijven') }}" class="btn btn-outline-light btn-lg shadow rounded-pill">
                <i class="bi bi-shop me-1"></i> Stand huren
              </a>
=======
              <a href="{{ url('/tickets') }}" class="btn btn-dark btn-lg shadow"><i class="bi bi-ticket-perforated me-1"></i> Tickets kopen</a>
              <a href="{{ url('/verkopers/inschrijven') }}" class="btn btn-outline-dark btn-lg shadow"><i class="bi bi-shop me-1"></i> Stand huren</a>
>>>>>>> 3a465e1e2ff37ef92f393aa14bb154825221052b
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="hero p-4 p-lg-5 h-100 bg-white rounded-4 shadow">
            <h5 class="fw-semibold mb-3">Event details</h5>
            <div class="d-grid gap-3">
              <div>
                <div class="small text-uppercase muted">Locatie</div>
                <div>Van Nellefabriek, Rotterdam</div>
              </div>
              <div class="border-top"></div>
              <div>
                <div class="small text-uppercase muted">Datum</div>
                <div>
                  @if(isset($event) && $event)
                    {{ \Illuminate\Support\Carbon::parse($event->Datum)->translatedFormat('j F Y') }} <span class="muted">(weekend)</span>
                  @else
                    November (exacte data t.b.c.)
                  @endif
                </div>
              </div>
              <div class="border-top"></div>
              <div>
                <div class="small text-uppercase muted">Capaciteit per tijdslot</div>
                <div>
                  @if(isset($event) && $event) {{ $event->AantalTicketsPerTijdslot }} tickets
                  @else 500 tickets
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<<<<<<< HEAD
        {{-- Hero Sidebar --}}
        <div class="col-lg-5">
          <div class="p-4 p-lg-5 h-100 glass text-white">
            <h5 class="fw-semibold mb-3">Event details</h5>
            <div class="d-grid gap-3">

              <div>
                <div class="small text-uppercase text-light">Locatie</div>
                <div class="fw-medium">Van Nellefabriek, Rotterdam</div>
              </div>

              <div class="divider"></div>

              <div>
                <div class="small text-uppercase text-light">Datum</div>
                <div>
                  @if(isset($event) && $event)
                    @php
                      $d = \Illuminate\Support\Carbon::parse($event->Datum)->locale('nl');
                    @endphp
                    {{ $d->translatedFormat('j F Y') }}
                    @if($d->isWeekend())
                      <span class="text-light-50">(weekend)</span>
                    @endif
                  @else
                    November (exacte data t.b.c.)
                  @endif
                </div>
              </div>

              <div class="divider"></div>

              <div>
                <div class="small text-uppercase text-light">Capaciteit per tijdslot</div>
                <div>
                  @if(isset($event) && $event)
                    {{ $event->AantalTicketsPerTijdslot }} tickets
                  @else
                    500 tickets
                  @endif
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ADMISSIONS / PRICES --}}
  <section class="py-4">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h4 m-0 text-white">Admissions & prijzen</h2>
        <a href="{{ url('/tickets') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Alle tijdsloten →</a>
      </div>

      @php
        // Groepeer prijzen per dag
        $grouped = collect($prices ?? [])->groupBy(fn($p) => \Illuminate\Support\Carbon::parse($p->Datum)->format('Y-m-d'));
        // Locale-bewuste valutaformatter (EUR)
        $currencyFmt = class_exists('\NumberFormatter')
          ? new \NumberFormatter('nl_NL', \NumberFormatter::CURRENCY)
          : null;
=======
  {{-- ADMISSIONS / PRIJZEN --}}
  <section class="py-4">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h4 m-0">Admissions & prijzen</h2>
        <a href="{{ url('/tickets') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Alle tijdsloten →</a>
      </div>

      @php
        $grouped = collect($prices ?? [])->groupBy(fn($p) => \Illuminate\Support\Carbon::parse($p->Datum)->format('Y-m-d'));
>>>>>>> 3a465e1e2ff37ef92f393aa14bb154825221052b
      @endphp

      @if(isset($prices) && count($prices))
        @foreach($grouped as $date => $items)
<<<<<<< HEAD
          @php
            // Bepaal het vroegste tijdslot van deze dag (voor “Vroege entree”)
            $earliestTime = $items->min(function($p) {
              return \Illuminate\Support\Carbon::parse($p->Tijdslot)->format('H:i');
            });
          @endphp

          <h6 class="mt-4 mb-3 text-uppercase text-light">
            {{ \Illuminate\Support\Carbon::parse($date)->locale('nl')->translatedFormat('l j F Y') }}
          </h6>

          <div class="row g-3">
            @foreach($items->sortBy('Tijdslot') as $p)
              @php
                $timeStr = \Illuminate\Support\Carbon::parse($p->Tijdslot)->format('H:i');
                $label = ($timeStr === $earliestTime) ? 'Vroege entree' : 'Reguliere entree';
                $price = $currencyFmt ? $currencyFmt->formatCurrency($p->Tarief, 'EUR')
                                      : ('€ ' . number_format($p->Tarief, 2, ',', '.'));
              @endphp
              <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card price-card h-100">
                  <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="fw-semibold">{{ $timeStr }}</span>
                      <span class="badge text-bg-dark price-badge">{{ $price }}</span>
                    </div>
                    <small class="muted mt-1">{{ $label }}</small>
                    <a class="btn btn-neon mt-3 mt-auto" href="{{ url('/tickets?slot='.$p->id) }}">Kies dit slot</a>
=======
          <h6 class="mt-4 mb-3 text-uppercase muted">{{ \Illuminate\Support\Carbon::parse($date)->translatedFormat('l j F Y') }}</h6>
          <div class="row g-3">
            @foreach($items->sortBy('Tijdslot') as $p)
              <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card h-100">
                  <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="fw-semibold">{{ \Illuminate\Support\Carbon::parse($p->Tijdslot)->format('H:i') }}</span>
                      <span class="badge text-bg-dark price-badge">€ {{ number_format($p->Tarief, 2, ',', '.') }}</span>
                    </div>
                    <small class="muted mt-1">
                      @if(\Illuminate\Support\Carbon::parse($p->Tijdslot)->format('H:i') === '11:00') Vroege entree @else Reguliere entree @endif
                    </small>
                    <a class="btn btn-dark mt-3 mt-auto" href="{{ url('/tickets?slot='.$p->id) }}">Kies dit slot</a>
>>>>>>> 3a465e1e2ff37ef92f393aa14bb154825221052b
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endforeach
      @else
<<<<<<< HEAD
        {{-- Fallback Pricing --}}
=======
        {{-- Fallback als er nog geen prijzen in DB staan --}}
>>>>>>> 3a465e1e2ff37ef92f393aa14bb154825221052b
        <div class="row g-3">
          @foreach([
            ['Zat','11:00','50,00','Vroege entree'],
            ['Zat','12:00','15,00','Reguliere entree'],
            ['Zat','14:00','12,00','Reguliere entree'],
            ['Zat','16:00','11,00','Reguliere entree'],
            ['Zon','12:00','14,00','Reguliere entree'],
            ['Zon','14:00','12,00','Reguliere entree'],
            ['Zon','16:00','10,00','Laatste entree'],
          ] as [$dag,$tijd,$prijs,$label])
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
<<<<<<< HEAD
              <div class="card price-card h-100">
=======
              <div class="card h-100">
>>>>>>> 3a465e1e2ff37ef92f393aa14bb154825221052b
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">{{ $dag }} {{ $tijd }}</span>
                    <span class="badge text-bg-dark price-badge">€ {{ $prijs }}</span>
                  </div>
                  <small class="muted mt-1">{{ $label }}</small>
<<<<<<< HEAD
                  <a class="btn btn-neon mt-3 mt-auto" href="{{ url('/tickets') }}">Kies dit slot</a>
=======
                  <a class="btn btn-dark mt-3 mt-auto" href="{{ url('/tickets') }}">Kies dit slot</a>
>>>>>>> 3a465e1e2ff37ef92f393aa14bb154825221052b
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
<<<<<<< HEAD


  </section>

  <!-- Scroll to Top Button -->
  <button id="scrollTopBtn" style="display:none;position:fixed;bottom:32px;right:32px;z-index:9999;" class="btn btn-neon shadow rounded-circle">
    <i class="bi bi-arrow-up"></i>
  </button>

  <script>
    // Show button when scrolled down
    window.addEventListener('scroll', function() {
      document.getElementById('scrollTopBtn').style.display =
        window.scrollY > 200 ? 'block' : 'none';
    });

    // Scroll to top on click
    document.getElementById('scrollTopBtn').onclick = function() {
      window.scrollTo({top: 0, behavior: 'smooth'});
    };
  </script>

=======
  </section>

  {{-- VERKOPERS --}}
  <section class="py-4">
    <div class="container">
      <div class="p-4 p-lg-5 bg-white border rounded-4 shadow">
        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
          <div>
            <h2 class="h4 mb-1">Verkopers & stands</h2>
            <p class="m-0 muted">Huur een stand (A, AA, AA+) voor één of twee dagen. Partners kunnen logo en extra info aanleveren.</p>
          </div>
          <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary rounded-pill px-4" href="{{ url('/verkopers') }}">Bekijk verkopers</a>
            <a class="btn btn-dark rounded-pill px-4" href="{{ url('/verkopers/inschrijven') }}">Inschrijven</a>
          </div>
        </div>
      </div>
    </div>
  </section>
>>>>>>> 3a465e1e2ff37ef92f393aa14bb154825221052b
</x-layout>