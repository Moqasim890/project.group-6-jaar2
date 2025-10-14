<x-layout>
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
              <p class="mt-2 text-white/80 text-base">
                Overzicht van alle evenementen — beheer datum, locatie en beschikbare stands.
              </p>
            </div>
            <div class="flex items-end gap-3">
              <form method="GET" action="{{ route('evenements.index') }}" class="m-0">
                <input
                  type="text"
                  name="q"
                  value="{{ request('q') }}"
                  placeholder="Zoek op naam of locatie…"
                  class="h-12 w-72 rounded-2xl border border-white/30 bg-white/20 px-5 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-pink-400"
                  aria-label="Zoeken in evenementen"
                />
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

      {{-- Succesmelding --}}
      @if(session('ok'))
        <div class="alert alert-success mb-4">{{ session('ok') }}</div>
      @endif

      {{-- Foutmelding --}}
      @if(session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
      @endif

      {{-- Validatiefouten --}}
      @if($errors->any())
        <div class="alert alert-danger mb-4">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if($events->count())
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
          @foreach($events as $e)
            <div class="group rounded-3xl border-2 border-pink-200 bg-white shadow-lg transition hover:shadow-xl flex flex-col">
              <div class="p-7 flex-1 flex flex-col">
                {{-- Bovenste rij: datum badge + id --}}
                <div class="mb-5 flex items-center justify-between">
                  <span class="inline-flex items-center rounded-full bg-pink-100 px-4 py-1 text-sm font-bold text-pink-700">
                    {{ \Illuminate\Support\Carbon::parse($e->Datum)->locale('nl')->translatedFormat('d MMM Y') }}
                  </span>
                  <span class="text-xs uppercase tracking-wider text-gray-400">#{{ $e->id }}</span>
                </div>

                {{-- Titel / locatie --}}
                <h2 class="line-clamp-1 text-2xl font-extrabold text-gray-900">{{ $e->Naam }}</h2>
                <p class="mt-2 text-base text-gray-600 flex items-center gap-1">
                  <svg class="h-5 w-5 text-pink-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/>
                  </svg>
                  {{ $e->Locatie }}
                </p>

                {{-- Meta --}}
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

              {{-- Acties verticaal --}}
              <div class="flex flex-col gap-2 px-7 pb-7">
                <a href="{{ route('evenements.show', $e) }}"
                   class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700 transition">
                  <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Details
                </a>
                <a href="{{ route('evenements.edit', $e) }}"
                   class="inline-flex items-center justify-center rounded-xl bg-pink-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-pink-600 transition">
                  <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5h2m-1 0v14m-7-7h14"/>
                  </svg>
                  Bewerken
                </a>
                <form method="POST" action="{{ route('evenements.destroy', $e) }}"
                      onsubmit="return confirm('Weet je zeker dat je dit evenement wilt verwijderen?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-red-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-600 transition">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Verwijderen
                  </button>
                </form>
              </div>
            </div>
          @endforeach
        </div>

        <div class="mt-10">
          {{ $events->links() }}
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
</x-layout>
