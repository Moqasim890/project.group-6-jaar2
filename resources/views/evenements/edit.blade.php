<x-layout>
  <section class="relative">
    {{-- hero background (optional: same sneaker image or gradient) --}}
    <div class="absolute inset-0">
      <div class="h-48 sm:h-64 w-full bg-[url('/images/hero.jpg')] bg-cover bg-center"></div>
      <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/50 to-black/30"></div>
    </div>

    <div class="relative mx-auto max-w-3xl px-6 py-12">
      <div class="rounded-2xl border border-white/10 bg-white/10 backdrop-blur-md shadow-2xl p-8">
        <h1 class="mb-6 text-2xl font-bold text-white drop-shadow">Bewerk evenement</h1>

        <form method="POST" action="{{ route('evenements.update',$evenement) }}" class="space-y-6">
          @csrf @method('PUT')
          @include('evenements.partials.form-fields', ['model' => $evenement])

          <div class="flex items-center gap-3">
            <a href="{{ route('evenements.index') }}"
               class="rounded-xl border border-white/30 bg-white/10 px-4 py-2 text-sm font-medium text-white hover:bg-white/20">
              Annuleer
            </a>
            <button
              class="rounded-xl bg-white/90 px-4 py-2 text-sm font-semibold text-gray-900 shadow hover:bg-white">
              Bijwerken
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
</x-layout>
