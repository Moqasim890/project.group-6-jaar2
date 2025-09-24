<x-layout>
  <div class="mx-auto max-w-3xl p-6">
    <h1 class="mb-6 text-2xl font-semibold">Nieuw evenement</h1>

    <form method="POST" action="{{ route('evenements.store') }}" class="space-y-5">
      @csrf

      <div>
        <label class="mb-1 block text-sm font-medium">Naam</label>
        <input name="Naam" value="{{ old('Naam') }}" required
               class="w-full rounded-lg border px-3 py-2" />
        @error('Naam') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div class="grid gap-5 sm:grid-cols-2">
        <div>
          <label class="mb-1 block text-sm font-medium">Datum</label>
          <input type="date" name="Datum" value="{{ old('Datum') }}" required
                 class="w-full rounded-lg border px-3 py-2" />
          @error('Datum') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="mb-1 block text-sm font-medium">Locatie</label>
          <input name="Locatie" value="{{ old('Locatie') }}" required
                 class="w-full rounded-lg border px-3 py-2" />
          @error('Locatie') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="grid gap-5 sm:grid-cols-2">
        <div>
          <label class="mb-1 block text-sm font-medium">Tickets per tijdslot</label>
          <input type="number" min="0" name="AantalTicketsPerTijdslot" value="{{ old('AantalTicketsPerTijdslot') }}" required
                 class="w-full rounded-lg border px-3 py-2" />
          @error('AantalTicketsPerTijdslot') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="mb-1 block text-sm font-medium">Beschikbare stands</label>
          <input type="number" min="0" name="BeschikbareStands" value="{{ old('BeschikbareStands') }}" required
                 class="w-full rounded-lg border px-3 py-2" />
          @error('BeschikbareStands') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="flex items-center gap-3">
        <input id="IsActief" type="checkbox" name="IsActief" value="1" {{ old('IsActief',1) ? 'checked' : '' }}
               class="h-4 w-4 rounded border" />
        <label for="IsActief" class="text-sm">Actief</label>
      </div>

      <div>
        <label class="mb-1 block text-sm font-medium">Opmerking</label>
        <textarea name="Opmerking" rows="3" class="w-full rounded-lg border px-3 py-2">{{ old('Opmerking') }}</textarea>
        @error('Opmerking') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div class="flex items-center gap-3">
        <a href="{{ route('evenements.index') }}" class="rounded-lg border px-4 py-2 text-sm hover:bg-gray-50">Annuleer</a>
        <button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:opacity-95">Opslaan</button>
      </div>
    </form>
  </div>
</x-layout>
