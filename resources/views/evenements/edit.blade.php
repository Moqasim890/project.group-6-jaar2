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

        {{-- Success message --}}
        @if(session('ok'))
          <div class="alert alert-success mb-4">{{ session('ok') }}</div>
        @endif

        {{-- Error message --}}
        @if(session('error'))
          <div class="alert alert-danger mb-4">{{ session('error') }}</div>
        @endif

        {{-- Validation errors --}}
        @if($errors->any())
          <div class="alert alert-danger mb-4">
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('evenements.update',$evenement) }}" class="space-y-6">
          @csrf @method('PUT')
          <div class="bg-white/80 rounded-xl p-6 shadow">
            @include('evenements.partials.form-fields', ['model' => $evenement])
          </div>
          <div class="flex items-center gap-3 mt-6">
            <a href="{{ route('evenements.index') }}"
               class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
              Annuleer
            </a>
            <button
              class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-800 transition">
              Bijwerken
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
</x-layout>
