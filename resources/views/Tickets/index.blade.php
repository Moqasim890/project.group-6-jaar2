<x-layout>
  <div class="container py-4">
    <h1 class="display-6 fw-bold mb-4 text-start">Kies je evenement</h1>

    {{-- Success Message Alert --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong>Gelukt!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

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
                <a href="{{ route('Tickets.showkopen', $event->id) }}" class="stretched-link"></a>
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

    {{-- Success Modal --}}
    @if(session('success'))
      <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white border-0">
              <h5 class="modal-title" id="successModalLabel">
                <i class="bi bi-check-circle-fill me-2"></i>
                🎉 Bestelling Succesvol!
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-5">
              <div class="mb-4">
                <div class="text-success mb-3" style="font-size: 5rem;">
                  <i class="bi bi-check-circle-fill"></i>
                </div>
                <h4 class="fw-bold text-success mb-3">Tickets Succesvol Gekocht!</h4>
                <p class="lead mb-4">{{ session('success') }}</p>
              </div>

              <div class="alert alert-info text-start" role="alert">
                <div class="d-flex align-items-start">
                  <i class="bi bi-info-circle-fill me-3 mt-1" style="font-size: 1.5rem;"></i>
                  <div>
                    <h6 class="fw-bold mb-2">Wat gebeurt er nu?</h6>
                    <ul class="mb-0 ps-3">
                      <li>Je ontvangt binnen enkele minuten een bevestigingsmail</li>
                      <li>In de mail vind je alle details van je tickets</li>
                      <li>Bewaar de mail goed - je hebt deze nodig bij de ingang</li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="text-muted mt-4">
                <small>
                  <i class="bi bi-envelope me-1"></i>
                  Geen email ontvangen? Controleer je spam folder of neem contact met ons op.
                </small>
              </div>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
              <button type="button" class="btn btn-success btn-lg px-5" data-bs-dismiss="modal">
                <i class="bi bi-check-lg me-2"></i> Begrepen, Bedankt!
              </button>
            </div>
          </div>
        </div>
      </div>

      {{-- Auto-open modal script --}}
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          var successModal = new bootstrap.Modal(document.getElementById('successModal'), {
            backdrop: 'static',
            keyboard: false
          });
          successModal.show();

          // Optional: Confetti effect (als je confetti library hebt)
          // confetti({
          //   particleCount: 100,
          //   spread: 70,
          //   origin: { y: 0.6 }
          // });
        });
      </script>
    @endif
  </div>
</x-layout>
