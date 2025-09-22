<x-layout>
  {{-- HERO --}}
  <section class="relative">
    <div class="absolute inset-0">
      {{-- achtergrond: gebruik je sneaker hero of een neutrale afbeelding --}}
      <div class="h-64 w-full bg-[url('/images/hero.jpg')] bg-cover bg-center"></div>
      <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/50 to-black/30"></div>
    </div>

    <div class="relative mx-auto max-w-3xl px-6 py-16">
      <div class="rounded-2xl border border-white/10 bg-white/10 p-10 backdrop-blur-md shadow-2xl text-center">
        <h1 class="mb-4 text-4xl font-extrabold text-white drop-shadow">🚧 Onderhoud</h1>
        <p class="mb-6 text-lg text-white/80">
          Deze pagina is tijdelijk niet beschikbaar.<br>
          Kom later terug of ga terug naar de homepagina.
        </p>
        <a href="{{ route('home') }}"
           class="inline-flex items-center rounded-xl bg-white/90 px-5 py-2.5 text-sm font-semibold text-gray-900 shadow hover:bg-white">
          ← Terug naar home
        </a>
      </div>
    </div>
  </section>
</x-layout>
