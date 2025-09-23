<x-layout>
  <div class="container py-4">
    <h1 class="display-6 fw-bold mb-4 text-start">Kies je evenement</h1>

    @forelse ($evenementen as $event)
      <!-- Grid: 1 / 2 / 3 columns per breakpoint -->
      @if ($loop->first)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
      @endif

          <div class="col">
            <div class="card h-100 shadow-sm border-0 position-relative">
              <div class="card-body">
                <h5 class="card-title mb-1 fw-semibold">
                  {{ $event->Naam }}
                </h5>

                <p class="card-text text-muted mb-0">
                  {{ $event->Locatie }}
                  <span class="mx-1">•</span>
                  {{ \Illuminate\Support\Carbon::parse($event->Datum)->locale('nl')->translatedFormat('d MMMM Y') }}
                </p>

                <!-- Make the whole card clickable -->
                <a href="{{ route('Tickets.show', $event) }}" class="stretched-link"></a>
              </div>
            </div>
          </div>

      @if ($loop->last)
        </div>
      @endif
    @empty
      <div class="alert alert-secondary d-flex align-items-center" role="alert">
        <i class="bi bi-info-circle me-2"></i>
        Geen evenementen op dit moment beschikbaar.
      </div>
    @endforelse>
  </div>
</x-layout>
