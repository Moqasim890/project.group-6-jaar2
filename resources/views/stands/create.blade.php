<x-layout>
  <div class="mx-auto max-w-4xl p-6">
    <h1 class="mb-6 text-2xl font-semibold">Nieuwe stand</h1>

    <div class="overflow-hidden rounded-xl border bg-white shadow-sm">
      <form method="POST" action="{{ route('stands.store') }}" class="p-6 space-y-6">
        @csrf

        <div class="grid gap-6 sm:grid-cols-2">
          <div>
            <label class="mb-1 block text-sm font-medium">Evenement</label>
            <select name="EvenementId" required class="w-full rounded-lg border px-3 py-2">
              <option value="">— kies evenement —</option>
              @foreach($events as $e)
                <option value="{{ $e->id }}" @selected(old('EvenementId')==$e->id)>{{ $e->Naam }}</option>
              @endforeach
            </select>
            @error('EvenementId') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label class="mb-1 block text-sm font-medium">Standtype</label>
            <select name="StandType" required class="w-full rounded-lg border px-3 py-2">
              @foreach(['A','AA','AAplus'] as $t)
                <option value="{{ $t }}" @selected(old('StandType')==$t)>{{ $t }}</option>
              @endforeach
            </select>
            @error('StandType') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
          <div>
            <label class="mb-1 block text-sm font-medium">Prijs (€)</label>
            <input type="number" name="Prijs" min="0" step="0.01" value="{{ old('Prijs') }}" required
                   class="w-full rounded-lg border px-3 py-2" />
            @error('Prijs') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label class="mb-1 block text-sm font-medium">Verkoper ID</label>
            <input type="number" name="VerkoperId" value="{{ old('VerkoperId') }}" required
                   class="w-full rounded-lg border px-3 py-2" />
            @error('VerkoperId') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>
        </div>

        <div class="flex gap-6">
          <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="VerhuurdStatus" value="1" {{ old('VerhuurdStatus',1) ? 'checked' : '' }}
                   class="h-4 w-4 rounded border" />
            Verhuurd
          </label>
          <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="IsActief" value="1" {{ old('IsActief',1) ? 'checked' : '' }}
                   class="h-4 w-4 rounded border" />
            Actief
          </label>
        </div>

        <div>
          <label class="mb-1 block text-sm font-medium">Opmerking</label>
          <textarea name="Opmerking" rows="3"
                    class="w-full rounded-lg border px-3 py-2">{{ old('Opmerking') }}</textarea>
          @error('Opmerking') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3">
          <a href="{{ route('stands.index') }}"
             class="rounded-lg border px-4 py-2 text-sm hover:bg-gray-50">Annuleer</a>
          <button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:opacity-95">
            Opslaan
          </button>
        </div>
      </form>
    </div>
  </div>
</x-layout>
