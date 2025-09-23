<x-layout>

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
              Art • Sport • Fashion • Muziek • <strong>Sneakers</strong>. Koop tickets per tijdslot — hoe eerder je binnen
              bent, hoe groter de kans op je grails.
            </p>
            <div class="d-flex gap-2 flex-wrap">
              <a href="{{ url('/tickets') }}" class="btn btn-neon btn-lg shadow">
                <i class="bi bi-ticket-perforated me-1"></i> Tickets kopen
              </a>
              <a href="{{ url('/verkopers/inschrijven') }}" class="btn btn-outline-light btn-lg shadow rounded-pill">
                <i class="bi bi-shop me-1"></i> Stand huren
              </a>
            </div>
          </div>
        </div>

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

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
