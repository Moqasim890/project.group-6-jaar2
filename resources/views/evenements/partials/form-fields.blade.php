@php
  // Helper to safely format the date for <input type="date">
  $dateValue = old('Datum',
    isset($model->Datum)
      ? (\Illuminate\Support\Carbon::parse($model->Datum)->format('Y-m-d'))
      : ''
  );

  // Reusable classes
  $label = 'mb-1 block text-sm font-medium text-white';
  $input = 'w-full h-11 rounded-lg border border-white/20 bg-white/10
            px-3 text-white placeholder-white/60
            focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent
            transition';
  $inputError = 'border-red-400 focus:ring-red-300';
  $help = 'mt-1 text-xs text-white/60';
  $err = 'mt-1 text-xs text-red-400';
@endphp

<div class="grid gap-6 sm:grid-cols-2">
  <div>
    <label class="{{ $label }}" for="naam">Naam</label>
    <input id="naam" type="text" name="Naam"
           value="{{ old('Naam', $model->Naam ?? '') }}"
           class="{{ $input }} @error('Naam') {{ $inputError }} @enderror"
           placeholder="Bijv. Sneakerness Rotterdam" />
    @error('Naam') <p class="{{ $err }}">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="{{ $label }}" for="locatie">Locatie</label>
    <input id="locatie" type="text" name="Locatie"
           value="{{ old('Locatie', $model->Locatie ?? '') }}"
           class="{{ $input }} @error('Locatie') {{ $inputError }} @enderror"
           placeholder="Bijv. Van Nellefabriek" />
    @error('Locatie') <p class="{{ $err }}">{{ $message }}</p> @enderror
  </div>
</div>

<div class="mt-6 grid gap-6 sm:grid-cols-2">
  <div>
    <label class="{{ $label }}" for="datum">Datum</label>
    <input id="datum" type="date" name="Datum"
           value="{{ $dateValue }}"
           class="{{ $input }} @error('Datum') {{ $inputError }} @enderror" />
    @error('Datum') <p class="{{ $err }}">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="{{ $label }}" for="stands">Beschikbare stands</label>
    <input id="stands" type="number" name="BeschikbareStands" min="0" inputmode="numeric"
           value="{{ old('BeschikbareStands', $model->BeschikbareStands ?? '') }}"
           class="{{ $input }} @error('BeschikbareStands') {{ $inputError }} @enderror" />
    @error('BeschikbareStands') <p class="{{ $err }}">{{ $message }}</p> @enderror
  </div>
</div>

<div class="mt-6 grid gap-6 sm:grid-cols-2">
  <div>
    <label class="{{ $label }}" for="tickets">Tickets per tijdslot</label>
    <input id="tickets" type="number" name="AantalTicketsPerTijdslot" min="0" inputmode="numeric"
           value="{{ old('AantalTicketsPerTijdslot', $model->AantalTicketsPerTijdslot ?? '') }}"
           class="{{ $input }} @error('AantalTicketsPerTijdslot') {{ $inputError }} @enderror" />
    @error('AantalTicketsPerTijdslot') <p class="{{ $err }}">{{ $message }}</p> @enderror
  </div>

  <div class="flex items-center gap-3 mt-7">
    {{-- send 0 when unchecked --}}
    <input type="hidden" name="IsActief" value="0">
    <input id="actief" type="checkbox" name="IsActief" value="1"
           {{ old('IsActief', $model->IsActief ?? false) ? 'checked' : '' }}
           class="h-5 w-5 rounded border-white/30 bg-white/10 text-white
                  focus:ring-2 focus:ring-white/30 focus:outline-none" />
    <label for="actief" class="text-sm font-medium text-white select-none">Actief</label>
  </div>
</div>

<div class="mt-6">
  <label class="{{ $label }}" for="opmerking">Opmerking</label>
  <textarea id="opmerking" name="Opmerking" rows="3"
            class="{{ $input }} min-h-[3rem] @error('Opmerking') {{ $inputError }} @enderror"
            placeholder="Interne notities of bijzonderheden…">{{ old('Opmerking', $model->Opmerking ?? '') }}</textarea>
  @error('Opmerking') <p class="{{ $err }}">{{ $message }}</p> @enderror
  <p class="{{ $help }}">Deze opmerking is alleen zichtbaar voor beheerders.</p>
</div>
