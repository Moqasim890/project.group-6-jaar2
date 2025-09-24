<x-layout>
  <section class="relative">
    {{-- Hero background --}}
    <div class="absolute inset-0">
      <div class="h-64 w-full bg-[url('/images/hero.jpg')] bg-cover bg-center"></div>
      <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/50 to-black/30"></div>
    </div>

    <div class="relative mx-auto max-w-6xl px-6 py-16">
      <div class="mb-10 flex items-center justify-between">
        <h1 class="text-3xl font-extrabold text-white drop-shadow">Stands</h1>
        <a href="{{ route('stands.create') }}"
           class="inline-flex items-center rounded-xl bg-white/90 px-5 py-2 text-sm font-semibold text-gray-900 shadow hover:bg-white">
          + Nieuwe stand
        </a>
      </div>

      @if($stands->count())
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
          @foreach($stands as $s)
            <div class="group rounded-2xl border border-white/10 bg-white/10 backdrop-blur-md p-6 shadow-xl transition hover:scale-[1.02] hover:bg-white/20">
              <div class="mb-4">
                <h2 class="text-xl font-bold text-white">
                  {{ optional($s->evenement)->Naam ?? '—' }}
                </h2>
                <p class="text-sm text-gray-200">Type: {{ $s->StandType }}</p>
              </div>

              <div class="space-y-2 text-sm text-white/90">
                <p>
                  <span class="font-medium">💶 Prijs:</span>
                  € {{ number_format($s->Prijs, 2, ',', '.') }}
                </p>
                <p>
                  <span class="font-medium">📌 Verhuurd:</span>
                  <span class="ml-1 rounded-full px-2 py-0.5 text-xs {{ $s->VerhuurdStatus ? 'bg-green-500/20 text-green-200' : 'bg-yellow-500/20 text-yellow-200' }}">
                    {{ $s->VerhuurdStatus ? 'Ja' : 'Nee' }}
                  </span>
                </p>
                <p>
                  <span class="font-medium">⚡ Status:</span>
                  <span class="ml-1 rounded-full px-2 py-0.5 text-xs {{ $s->IsActief ? 'bg-green-500/20 text-green-200' : 'bg-gray-500/30 text-gray-300' }}">
                    {{ $s->IsActief ? 'Actief' : 'Inactief' }}
                  </span>
                </p>
              </div>

              <div class="mt-6 flex justify-end gap-2">
                <a href="{{ route('stands.edit',$s) }}"
                   class="rounded-lg border border-white/20 bg-white/10 px-3 py-1.5 text-xs text-white hover:bg-white/20">
                  ✏️ Bewerk
                </a>
                <form method="POST" action="{{ route('stands.destroy',$s) }}"
                      onsubmit="return confirm('Verwijderen?')">
                  @csrf @method('DELETE')
                  <button
                    class="rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-1.5 text-xs text-red-200 hover:bg-red-500/20">
                    🗑️ Verwijder
                  </button>
                </form>
              </div>
            </div>
          @endforeach
        </div>

        <div class="mt-10">
          {{ $stands->links() }}
        </div>
      @else
        <p class="text-center text-sm text-gray-300 py-12">
          Geen stands gevonden.
        </p>
      @endif
    </div>
  </section>
</x-layout>
