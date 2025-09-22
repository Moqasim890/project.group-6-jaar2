<div class="grid gap-6 sm:grid-cols-2">
  <div>
    <label class="mb-1 block text-sm font-medium text-white">Naam</label>
    <input type="text" name="Naam"
           value="{{ old('Naam', $model->Naam ?? '') }}"
           class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-gray-500 focus:ring-2 focus:ring-gray-300" />
  </div>

  <div>
    <label class="mb-1 block text-sm font-medium text-white">Locatie</label>
    <input type="text" name="Locatie"
           value="{{ old('Locatie', $model->Locatie ?? '') }}"
           class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-gray-500 focus:ring-2 focus:ring-gray-300" />
  </div>
</div>

<div class="grid gap-6 sm:grid-cols-2">
  <div>
    <label class="mb-1 block text-sm font-medium text-white">Datum</label>
    <input type="date" name="Datum"
           value="{{ old('Datum', $model->Datum ?? '') }}"
           class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900" />
  </div>

  <div>
    <label class="mb-1 block text-sm font-medium text-white">Beschikbare stands</label>
    <input type="number" name="BeschikbareStands" min="0"
           value="{{ old('BeschikbareStands', $model->BeschikbareStands ?? '') }}"
           class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900" />
  </div>
</div>

<div class="grid gap-6 sm:grid-cols-2">
  <div>
    <label class="mb-1 block text-sm font-medium text-white">Tickets per tijdslot</label>
    <input type="number" name="AantalTicketsPerTijdslot" min="0"
           value="{{ old('AantalTicketsPerTijdslot', $model->AantalTicketsPerTijdslot ?? '') }}"
           class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900" />
  </div>

  <div class="flex items-center gap-2">
    <input type="checkbox" name="IsActief" value="1"
           {{ old('IsActief', $model->IsActief ?? false) ? 'checked' : '' }}
           class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-400" />
    <label class="text-sm font-medium text-white">Actief</label>
  </div>
</div>

<div>
  <label class="mb-1 block text-sm font-medium text-white">Opmerking</label>
  <textarea name="Opmerking" rows="3"
            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900">{{ old('Opmerking', $model->Opmerking ?? '') }}</textarea>
</div>
