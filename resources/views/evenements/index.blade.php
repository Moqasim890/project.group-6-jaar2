<x-layout>
  {{-- HERO / HEADER (stable grid, no overlap) --}}
  <section class="relative">
    <div class="relative h-48 sm:h-56">
      <div class="absolute inset-0 bg-[url('/images/hero.jpg')] bg-cover bg-center"></div>
      <div class="absolute inset-0 bg-black/50"></div>

      <div class="relative mx-auto flex h-full max-w-6xl items-end px-6">
        <div class="w-full pb-5">
          {{-- grid keeps title/intro at left and actions at right without floating --}}
          <div class="grid grid-cols-1 gap-4 md:grid-cols-[1fr_auto] md:items-end">
            <div>
              <p class="text-xs tracking-widest text-white/70 uppercase">Beheer</p>
              <h1 class="text-3xl font-extrabold text-white">Evenementen</h1>
              <p class="mt-1 text-white/80 text-sm">
                Overzicht van alle events — beheer datum, locatie en beschikbare stands.
              </p>
            </div>

            <div class="flex items-end justify-start gap-3 md:justify-end">
              <form method="GET" action="{{ route('evenements.index') }}" class="m-0">
                <input
                  type="text"
                  name="q"
                  value="{{ request('q') }}"
                  placeholder="Zoek op naam of locatie…"
                  class="h-10 w-64 md:w-72 rounded-xl border border-white/30 bg-white/10 px-4 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/40"
                  aria-label="Zoeken in evenementen"
                />
              </form>

              <a href="{{ route('evenements.create') }}"
                 class="h-10 inline-flex items-center rounded-xl bg-white px-4 text-sm font-semibold text-gray-900 shadow hover:bg-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
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
  <section class="py-8">
    <div class="mx-auto max-w-6xl px-6">
      @if($events->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          @foreach($events as $e)
            <div class="group rounded-2xl border border-gray-200 bg-white shadow-sm transition-shadow hover:shadow-md">
              <div class="p-5">
                {{-- Top row: date badge + id --}}
                <div class="mb-4 flex items-center justify-between">
                  <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                    {{ \Illuminate\Support\Carbon::parse($e->Datum)->locale('nl')->translatedFormat('d MMM Y') }}
                  </span>
                  <span class="text-[10px] uppercase tracking-wider text-gray-400">#{{ $e->id }}</span>
                </div>

                {{-- Title / location --}}
                <h2 class="line-clamp-1 text-lg font-semibold text-gray-900">{{ $e->Naam }}</h2>
                <p class="mt-1 text-sm text-gray-600">
                  <svg class="mr-1 inline h-4 w-4 -mt-0.5 align-middle" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/>
                  </svg>
                  {{ $e->Locatie }}
                </p>

                {{-- Meta --}}
                <div class="mt-4 grid grid-cols-2 gap-3">
                  <div class="rounded-xl border border-gray-200 bg-gray-50 px-3 py-2">
                    <p class="text-[11px] uppercase tracking-wide text-gray-500">Beschikbare stands</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $e->BeschikbareStands }}</p>
                  </div>
                  <div class="rounded-xl border border-gray-200 bg-gray-50 px-3 py-2">
                    <p class="text-[11px] uppercase tracking-wide text-gray-500">Tickets/slot</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $e->AantalTicketsPerTijdslot }}</p>
                  </div>
                </div>

                {{-- Actions --}}
                <div class="mt-5 flex items-center justify-between">
                  <a href="{{ route('evenements.edit', $e) }}"
                     class="inline-flex items-center rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 transition">
                    Bewerk
                  </a>
                  <form method="POST" action="{{ route('evenements.destroy', $e) }}"
                        onsubmit="return confirm('Weet je zeker dat je dit evenement wilt verwijderen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      class="inline-flex items-center rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100 transition">
                      Verwijder
                    </button>
                  </form>
                </div>
              </div>

              {{-- Bottom bar hover accent --}}
              <div class="h-1 w-full rounded-b-2xl bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200 transition-all group-hover:from-gray-300 group-hover:to-gray-300"></div>
            </div>
          @endforeach
        </div>

        <div class="mt-8">
          {{ $events->links() }}
        </div>
      @else
        <div class="rounded-2xl border border-gray-200 bg-white p-10 text-center shadow-sm">
          <p class="text-gray-500">Geen evenementen gevonden.</p>
          <a href="{{ route('evenements.create') }}"
             class="mt-4 inline-flex items-center rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:opacity-95 transition">
            + Nieuw evenement
          </a>
        </div>
      @endif
    </div>
  </section>
</x-layout>
