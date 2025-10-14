<x-layout>
  <section class="py-16">
    <div class="mx-auto max-w-2xl px-6">
      <div class="rounded-3xl bg-white shadow-2xl border-2 border-pink-200 p-10">
        <div class="flex flex-col items-center gap-4">
          <div class="flex items-center gap-3">
            <span class="inline-flex items-center rounded-full bg-pink-100 px-4 py-1 text-sm font-bold text-pink-700">
              {{ \Illuminate\Support\Carbon::parse($evenement->Datum)->locale('nl')->translatedFormat('d MMM Y') }}
            </span>
            <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
              #{{ $evenement->id }}
            </span>
            @if($evenement->IsActief)
              <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                Actief
              </span>
            @else
              <span class="inline-flex items-center rounded-full bg-gray-200 px-3 py-1 text-xs font-semibold text-gray-700">
                Inactief
              </span>
            @endif
          </div>
          <h1 class="text-3xl font-black text-gray-900 text-center drop-shadow">{{ $evenement->Naam }}</h1>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-6">
          <div class="flex items-center gap-3">
            <span class="inline-block rounded-xl bg-indigo-50 p-3">
              <svg class="h-6 w-6 text-indigo-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
            </span>
            <div>
              <div class="text-xs text-gray-500 uppercase font-bold">Locatie</div>
              <div class="text-lg font-semibold text-gray-800">{{ $evenement->Locatie }}</div>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <span class="inline-block rounded-xl bg-pink-50 p-3">
              <svg class="h-6 w-6 text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M16 2v2H8V2H5v2H3v2h18V4h-2V2h-3zm-1 6v2H9V8H7v2H5v2h14v-2h-2V8h-3zm-1 6v2H9v-2H7v2H5v2h14v-2h-2v-2h-3z"/></svg>
            </span>
            <div>
              <div class="text-xs text-gray-500 uppercase font-bold">Tickets per tijdslot</div>
              <div class="text-lg font-semibold text-gray-800">{{ $evenement->AantalTicketsPerTijdslot }}</div>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <span class="inline-block rounded-xl bg-green-50 p-3">
              <svg class="h-6 w-6 text-green-400" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v2H4zm0 6h16v2H4zm0 6h16v2H4z"/></svg>
            </span>
            <div>
              <div class="text-xs text-gray-500 uppercase font-bold">Beschikbare stands</div>
              <div class="text-lg font-semibold text-gray-800">{{ $evenement->BeschikbareStands }}</div>
            </div>
          </div>
          @if($evenement->Opmerking)
            <div class="flex items-center gap-3">
              <span class="inline-block rounded-xl bg-yellow-50 p-3">
                <svg class="h-6 w-6 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2H10c0 1.1.9 2 2 2zm6-6V11c0-3.07-1.63-5.64-4.5-6.32V4a1.5 1.5 0 0 0-3 0v.68C7.63 5.36 6 7.92 6 11v5l-1.7 1.7c-.14.14-.3.33-.3.53V19c0 .55.45 1 1 1h14c.55 0 1-.45 1-1v-.77c0-.2-.16-.39-.3-.53L18 16z"/></svg>
              </span>
              <div>
                <div class="text-xs text-gray-500 uppercase font-bold">Opmerking</div>
                <div class="text-lg font-semibold text-gray-800">{{ $evenement->Opmerking }}</div>
              </div>
            </div>
          @endif
        </div>

        <div class="mt-10 flex justify-center">
          <a href="{{ route('evenements.index') }}"
             class="inline-flex items-center rounded-2xl bg-indigo-600 px-6 py-3 text-base font-bold text-white hover:bg-indigo-700 transition shadow">
            Terug naar overzicht
          </a>
        </div>
      </div>
    </div>
  </section>
</x-layout>