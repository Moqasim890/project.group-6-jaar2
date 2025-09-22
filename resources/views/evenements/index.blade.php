<x-layout>
  {{-- HERO / HEADER --}}
  <section class="relative">
    <div class="absolute inset-0">
      {{-- use any image you like here; a subtle gradient fallback keeps it elegant --}}
      <div class="h-48 sm:h-64 w-full bg-[url('/images/hero.jpg')] bg-cover bg-center"></div>
      <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/50 to-black/30"></div>
    </div>

    <div class="relative mx-auto max-w-6xl px-6 py-10 sm:py-14">
      <div class="rounded-2xl border border-white/10 bg-white/10 p-6 backdrop-blur-md shadow-2xl">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
          <div>
            <p class="text-xs tracking-widest text-white/70 uppercase">Beheer</p>
            <h1 class="text-3xl font-extrabold text-white drop-shadow-sm">Evenementen</h1>
            <p class="mt-1 text-white/80 text-sm">
              Overzicht van alle events — beheer datum, locatie en beschikbare stands.
            </p>
          </div>

          <div class="flex gap-3">
            {{-- optional: quick search (non-functional by default; wire it up later) --}}
            <form method="GET" action="{{ route('evenements.index') }}" class="hidden sm:block">
              <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Zoek op naam of locatie…"
                class="rounded-xl border border-white/20 bg-black/30 px-4 py-2 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30"
              />
            </form>

            <a href="{{ route('evenements.create') }}"
               class="inline-flex items-center rounded-xl bg-white/90 px-4 py-2 text-sm font-semibold text-gray-900 shadow hover:bg-white">
              <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5c.552 0 1 .448 1 1v5h5c.552 0 1 .448 1 1s-.448 1-1 1h-5v5c0 .552-.448 1-1 1s-1-.448-1-1v-5H6c-.552 0-1-.448-1-1s .448-1 1-1h5V6c0-.552.448-1 1-1z"/></svg>
              Nieuw evenement
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- CONTENT --}}
  <div class="mx-auto max-w-6xl px-6 pb-10 -mt-6">
    @if($events->count())
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($events as $e)
          <div class="group rounded-2xl border bg-white shadow-sm transition-shadow hover:shadow-lg">
            <div class="p-5">
              {{-- Top row: date badge + status --}}
              <div class="mb-4 flex items-center justify-between">
                <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                  {{ \Illuminate\Support\Carbon::parse($e->Datum)->format('d M Y') }}
                </span>
                <span class="text-[10px] uppercase tracking-wider text-gray-400">#{{ $e->id }}</span>
              </div>

              {{-- Title / location --}}
              <h2 class="line-clamp-1 text-lg font-semibold text-gray-900">{{ $e->Naam }}</h2>
              <p class="mt-1 text-sm text-gray-500">
                <svg class="mr-1 inline h-4 w-4 -mt-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
                {{ $e->Locatie }}
              </p>

              {{-- Meta --}}
              <div class="mt-4 grid grid-cols-2 gap-3">
                <div class="rounded-xl border bg-gray-50 px-3 py-2">
                  <p class="text-[11px] uppercase tracking-wide text-gray-500">Beschikbare stands</p>
                  <p class="text-sm font-semibold text-gray-900">{{ $e->BeschikbareStands }}</p>
                </div>
                <div class="rounded-xl border bg-gray-50 px-3 py-2">
                  <p class="text-[11px] uppercase tracking-wide text-gray-500">Tickets/slot</p>
                  <p class="text-sm font-semibold text-gray-900">{{ $e->AantalTicketsPerTijdslot }}</p>
                </div>
              </div>

              {{-- Actions --}}
              <div class="mt-5 flex items-center justify-between">
                <a href="{{ route('evenements.edit', $e) }}"
                   class="inline-flex items-center rounded-lg border px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                  Bewerk
                </a>

                <form method="POST" action="{{ route('evenements.destroy', $e) }}"
                      onsubmit="return confirm('Weet je zeker dat je dit evenement wilt verwijderen?')">
                  @csrf @method('DELETE')
                  <button
                    class="inline-flex items-center rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100">
                    Verwijder
                  </button>
                </form>
              </div>
            </div>

            {{-- Subtle bottom bar that animates on hover --}}
            <div class="h-1 w-full rounded-b-2xl bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200 transition-all group-hover:from-gray-300 group-hover:to-gray-300"></div>
          </div>
        @endforeach
      </div>

      <div class="mt-8">
        {{ $events->links() }}
      </div>
    @else
      <div class="rounded-2xl border bg-white p-10 text-center shadow-sm">
        <p class="text-gray-500">Geen evenementen gevonden.</p>
        <a href="{{ route('evenements.create') }}"
           class="mt-4 inline-flex items-center rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:opacity-95">
          + Nieuw evenement
        </a>
      </div>
    @endif
  </div>
</x-layout>
