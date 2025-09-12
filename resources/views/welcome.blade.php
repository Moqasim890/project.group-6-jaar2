<x-layout>
  {{-- HERO --}}
  <section class="py-5" style="background: rgba(255,255,255,0.85); border-radius: 2rem; margin-top: 2rem;">
    <div class="container">
      <div class="row g-4 align-items-stretch">
        <div class="col-lg-7">
          <div class="hero p-4 p-lg-5 h-100">
            <span class="badge text-bg-danger mb-2">Van Nellefabriek • Rotterdam • November</span>
            <h1 class="display-6 fw-semibold mb-2">De grootste sneaker-community van Europa komt samen.</h1>
            <p class="lead muted mb-4">
              Art • Sport • Fashion • Muziek • <strong>Sneakers</strong>. Koop tickets per tijdslot — hoe eerder je binnen
              bent, hoe groter de kans op je grails.
            </p>
            <div class="d-flex gap-2 flex-wrap">
              <a href="{{ url('/tickets') }}" class="btn btn-dark btn-lg shadow"><i class="bi bi-ticket-perforated me-1"></i> Tickets kopen</a>
              <a href="{{ url('/verkopers/inschrijven') }}" class="btn btn-outline-dark btn-lg shadow"><i class="bi bi-shop me-1"></i> Stand huren</a>
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

  {{-- ADMISSIONS / PRIJZEN --}}
  <section class="py-4">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h4 m-0">Admissions & prijzen</h2>
        <a href="{{ url('/tickets') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Alle tijdsloten →</a>
      </div>

      @php
        $grouped = collect($prices ?? [])->groupBy(fn($p) => \Illuminate\Support\Carbon::parse($p->Datum)->format('Y-m-d'));
      @endphp

      @if(isset($prices) && count($prices))
        @foreach($grouped as $date => $items)
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
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endforeach
      @else
        {{-- Fallback als er nog geen prijzen in DB staan --}}
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
              <div class="card h-100">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">{{ $dag }} {{ $tijd }}</span>
                    <span class="badge text-bg-dark price-badge">€ {{ $prijs }}</span>
                  </div>
                  <small class="muted mt-1">{{ $label }}</small>
                  <a class="btn btn-dark mt-3 mt-auto" href="{{ url('/tickets') }}">Kies dit slot</a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
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
</x-layout>