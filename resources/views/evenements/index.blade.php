<x-layout>
  @php
    // Optional test hook so you can verify without controller changes. Remove later if you want.
    if(request()->has('commit')) session()->flash('commit_msg', request('commit'));

    $__commit = session('commit_msg') ?? session('ok') ?? session('error');
  @endphp

  {{-- HERO / HEADER --}}
  <section class="relative">
    <div class="relative h-56">
      <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 bg-cover bg-center"></div>
      <div class="absolute inset-0 bg-black/40"></div>
      <div class="relative mx-auto flex h-full max-w-6xl items-end px-6">
        <div class="w-full pb-6">
          <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
              <p class="text-xs tracking-widest text-white/70 uppercase">Beheer</p>
              <h1 class="text-4xl font-black text-white drop-shadow">Evenementen</h1>
              <p class="mt-2 text-white/80 text-base">Overzicht van alle evenementen — beheer datum, locatie en beschikbare stands.</p>
            </div>
            <div class="flex items-end gap-3">
              <form method="GET" action="{{ route('evenements.index') }}" class="m-0">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Zoek op naam of locatie…"
                       class="h-12 w-72 rounded-2xl border border-white/30 bg-white/20 px-5 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-pink-400"
                       aria-label="Zoeken in evenementen" />
              </form>
              <a href="{{ route('evenements.create') }}"
                 class="h-12 inline-flex items-center rounded-2xl bg-pink-500 px-6 text-base font-bold text-white shadow-lg hover:bg-pink-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M12 5c.552 0 1 .448 1 1v5h5c.552 0 1 .448 1 1s-.448 1-1 1h-5v5c0 .552-.448 1-1 1s-1-.448-1-1v-5H6c-.552 0-1-.448-1-1s.448-1 1-1h5V6c0-.552.448-1 1-1z"/>
                </svg>
                Nieuw evenement
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- CONTENT --}}
  <section class="py-10">
    <div class="mx-auto max-w-7xl px-6">
      @if($events->count())
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
          @foreach($events as $e)
            <div class="group rounded-3xl border-2 border-pink-200 bg-white shadow-lg transition hover:shadow-xl flex flex-col">
              <div class="p-7 flex-1 flex flex-col">
                <div class="mb-5 flex items-center justify-between gap-3">
                  <div class="flex items-center gap-2">
                    <span class="inline-flex items-center rounded-full bg-pink-100 px-4 py-1 text-sm font-bold text-pink-700">
                      {{ \Illuminate\Support\Carbon::parse($e->Datum)->locale('nl')->translatedFormat('d MMM Y') }}
                    </span>
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold {{ $e->IsActief ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                      {{ $e->IsActief ? 'Actief' : 'Inactief' }}
                    </span>
                  </div>
                  <span class="text-xs uppercase tracking-wider text-gray-400">#{{ $e->id }}</span>
                </div>

                <h2 class="line-clamp-1 text-2xl font-extrabold text-gray-900">{{ $e->Naam }}</h2>
                <p class="mt-2 text-base text-gray-600 flex items-center gap-1">
                  <svg class="h-5 w-5 text-pink-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/>
                  </svg>
                  {{ $e->Locatie }}
                </p>

                <div class="mt-6 grid grid-cols-2 gap-4">
                  <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Beschikbare stands</p>
                    <p class="text-lg font-bold text-gray-900">{{ $e->BeschikbareStands }}</p>
                  </div>
                  <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Tickets per tijdslot</p>
                    <p class="text-lg font-bold text-gray-900">{{ $e->AantalTicketsPerTijdslot }}</p>
                  </div>
                </div>
              </div>

              <div class="flex flex-col gap-2 px-7 pb-3">
                <a href="{{ route('evenements.show', $e) }}" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700 transition">
                  <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                  Details
                </a>
                <a href="{{ route('evenements.edit', $e) }}" class="inline-flex items-center justify-center rounded-xl bg-pink-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-pink-600 transition">
                  <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5h2m-1 0v14m-7-7h14"/></svg>
                  Bewerken
                </a>

                @if(!$e->IsActief)
                  <form method="POST" action="{{ route('evenements.destroy', $e) }}"
                        onsubmit="return confirm('Weet je zeker dat je dit (inactieve) evenement wilt verwijderen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-red-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-600 transition">
                      <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                      Verwijderen
                    </button>
                  </form>
                @else
                  <button type="button" disabled title="Actieve evenementen kunnen niet worden verwijderd" class="inline-flex items-center justify-center rounded-xl bg-gray-300 px-4 py-2 text-sm font-semibold text-gray-600 cursor-not-allowed">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    Verwijderen (geblokkeerd)
                  </button>
                @endif
              </div>

              @if($e->IsActief)
                <div class="px-7 pb-7">
                  <p class="mt-2 text-xs font-semibold text-yellow-700 bg-yellow-50 border border-yellow-200 rounded-lg px-3 py-2">
                    ⚠ Dit evenement is actief en kan niet worden verwijderd. Zet het eerst op “Inactief” via <em>Bewerken</em>.
                  </p>
                </div>
              @endif
            </div>
          @endforeach
        </div>

        <div class="mt-10">
          {{ $events->withQueryString()->links() }}
        </div>
      @else
        <div class="rounded-3xl border-2 border-pink-200 bg-white p-16 text-center shadow-lg">
          <p class="text-gray-500 text-lg">Geen evenementen gevonden.</p>
          <a href="{{ route('evenements.create') }}"
             class="mt-6 inline-flex items-center rounded-2xl bg-pink-500 px-6 py-3 text-base font-bold text-white hover:bg-pink-600 transition">
            + Nieuw evenement
          </a>
        </div>
      @endif
    </div>
  </section>

  {{-- Success Modal --}}
  @if(session('ok'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2"></i>Gelukt!</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Sluiten"></button>
          </div>
          <div class="modal-body text-center py-4">
            <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
            <h4 class="mt-3">{{ session('ok') }}</h4>
          </div>
          <div class="modal-footer"><button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button></div>
        </div>
      </div>
    </div>
  @endif

  {{-- Error Modal --}}
  @if(session('error') || $errors->any())
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Fout</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Sluiten"></button>
          </div>
          <div class="modal-body text-center py-4">
            <i class="bi bi-x-circle text-danger" style="font-size: 4rem;"></i>
            <h4 class="mt-3">Er is een fout opgetreden</h4>
            <div class="text-muted">
              @if(session('error')) <p>{{ session('error') }}</p> @endif
              @if($errors->any())
                <ul class="list-unstyled mb-0">
                  @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
              @endif
            </div>
          </div>
          <div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button></div>
        </div>
      </div>
    </div>
  @endif

  {{-- COMMIT/BACKLOG TOAST (Bootstrap if present, otherwise vanilla) --}}
  @if($__commit)
    <style>
      .__toast-wrap{position:fixed;top:1rem;right:1rem;z-index:2147483647}
      .__toast{display:flex;align-items:center;gap:.75rem;min-width:280px;max-width:420px;
        background:#111;color:#fff;padding:.75rem 1rem;border-radius:.5rem;box-shadow:0 10px 30px rgba(0,0,0,.25);
        opacity:0;transform:translateY(-8px);transition:opacity .18s ease, transform .18s ease}
      .__toast.__show{opacity:1;transform:translateY(0)}
      .__toast-btn{background:transparent;border:0;color:#fff;opacity:.7;cursor:pointer}
      .__toast-btn:hover{opacity:1}
      .__toast-badge{font-weight:700;margin-right:.35rem}
    </style>

    <div class="__toast-wrap" aria-live="polite" aria-atomic="true">
      <div id="commitToast" class="toast align-items-center text-bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="6000" style="display:none">
        <div class="d-flex">
          <div class="toast-body"><strong class="me-2">Backlog</strong> {{ $__commit }}</div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Sluiten"></button>
        </div>
      </div>

      <div id="commitToastFallback" class="__toast" role="status" style="display:none">
        <span class="__toast-badge">Backlog</span> <span>{{ $__commit }}</span>
        <button type="button" class="__toast-btn" aria-label="Sluiten" onclick="this.closest('.__toast').remove()">&times;</button>
      </div>

      <noscript>
        <div class="__toast __show"><span class="__toast-badge">Backlog</span> <span>{{ $__commit }}</span></div>
      </noscript>
    </div>
  @endif

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // show success/error modals only if Bootstrap Modal is available
      @if(session('ok'))
        const sm = document.getElementById('successModal');
        if (sm && window.bootstrap && bootstrap.Modal) new bootstrap.Modal(sm).show();
      @endif
      @if(session('error') || $errors->any())
        const em = document.getElementById('errorModal');
        if (em && window.bootstrap && bootstrap.Modal) new bootstrap.Modal(em).show();
      @endif

      // toast init: prefer Bootstrap, else fallback
      @if($__commit)
        const bsEl = document.getElementById('commitToast');
        const fbEl = document.getElementById('commitToastFallback');

        if (window.bootstrap && bootstrap.Toast && bsEl) {
          bsEl.style.display = '';
          new bootstrap.Toast(bsEl).show();
        } else if (fbEl) {
          fbEl.style.display = '';
          requestAnimationFrame(() => fbEl.classList.add('__show'));
          setTimeout(() => fbEl.remove(), 6000);
        }
      @endif
    });
  </script>
</x-layout>
