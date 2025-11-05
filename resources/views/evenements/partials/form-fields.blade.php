{{-- Expect the controller to pass existing {date,location} pairs to prevent duplicates on the client. --}}
@php
  /** @var array<array{date:string, location:string}> $existingDateLocations */
  $existingDateLocations = $existingDateLocations ?? [];
@endphp

<div class="mb-3">
  <label class="form-label">Naam</label>
  <input name="Naam"
         value="{{ old('Naam', $model->Naam ?? '') }}"
         required
         maxlength="255"
         class="form-control" />
  @error('Naam') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  <div class="form-text"><span id="naam_counter">0</span>/255</div>
</div>

<div class="row mb-3">
  <div class="col-sm-6">
    <label class="form-label">Datum</label>
    @php
      $datumOld = old('Datum');
      if (!empty($datumOld)) {
        $datumValue = $datumOld;
      } else {
        if (isset($model) && !empty($model->Datum)) {
          try {
            if ($model->Datum instanceof \Illuminate\Support\Carbon) {
              $datumValue = $model->Datum->format('Y-m-d');
            } else {
              $datumValue = \Illuminate\Support\Carbon::parse($model->Datum)->format('Y-m-d');
            }
          } catch (\Exception $e) { $datumValue = ''; }
        } else { $datumValue = ''; }
      }
    @endphp
    <input type="date" name="Datum" id="Datum"
           value="{{ $datumValue }}"
           required class="form-control" />
    @error('Datum') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    <div class="text-danger small mt-1" id="date_loc_error" style="display:none;"></div>
  </div>

  <div class="col-sm-6">
    <label class="form-label">Locatie</label>
    @php
      $presetLocations = ['Utrecht','Amsterdam','Rotterdam','Den Haag','Eindhoven','Groningen','Maastricht','Breda'];
      $oldLoc = old('Locatie', $model->Locatie ?? '');
    @endphp

    <select id="locatie_select" class="form-select mb-2">
      <option value="">— kies locatie —</option>
      @foreach($presetLocations as $loc)
        <option value="{{ $loc }}" @selected($oldLoc === $loc)>{{ $loc }}</option>
      @endforeach
      <option value="__other" @selected($oldLoc && !in_array($oldLoc, $presetLocations))>Anders...</option>
    </select>

    <div id="locatie_custom_wrapper" style="display:none;">
      <input id="locatie_custom" type="text"
             maxlength="255"
             class="form-control mb-1"
             placeholder="Voer locatie in (max 255 tekens)" />
      <div class="form-text"><span id="loc_counter">0</span>/255</div>
    </div>

    <input type="hidden" name="Locatie" id="Locatie" value="{{ $oldLoc }}" />
    @error('Locatie') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>
</div>

<div class="row mb-3">
  <div class="col-sm-6">
    <label class="form-label">Tickets per tijdslot</label>
    <input type="number" name="AantalTicketsPerTijdslot"
           min="0" max="500000" step="1" required
           inputmode="numeric" pattern="[0-9]*"
           class="form-control block-int-only" 
           value="{{ old('AantalTicketsPerTijdslot', $model->AantalTicketsPerTijdslot ?? '') }}" />
    @error('AantalTicketsPerTijdslot') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>
  <div class="col-sm-6">
    <label class="form-label">Beschikbare stands</label>
    <input type="number" name="BeschikbareStands"
           min="0" max="500000" step="1" required
           inputmode="numeric" pattern="[0-9]*"
           class="form-control block-int-only" 
           value="{{ old('BeschikbareStands', $model->BeschikbareStands ?? '') }}" />
    @error('BeschikbareStands') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>
</div>

<div class="form-check mb-3">
  <input id="IsActief" type="checkbox" name="IsActief" value="1"
         {{ old('IsActief', $model->IsActief ?? 1) ? 'checked' : '' }} class="form-check-input" />
  <label for="IsActief" class="form-check-label">Actief</label>
</div>

<div class="mb-3">
  <label class="form-label">Opmerking</label>
  <textarea name="Opmerking" rows="3" maxlength="255" class="form-control">{{ old('Opmerking', $model->Opmerking ?? '') }}</textarea>
  @error('Opmerking') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  <div class="form-text"><span id="opm_counter">{{ mb_strlen(old('Opmerking', $model->Opmerking ?? '')) }}</span>/255</div>
</div>

{{-- Client-side rules: no duplicate same-date+same-location, numeric hardening, and counters --}}
<script>
(function(){
  const select = document.getElementById('locatie_select');
  const customWrap = document.getElementById('locatie_custom_wrapper');
  const customInput = document.getElementById('locatie_custom');
  const hidden = document.getElementById('Locatie');
  const dateInput = document.getElementById('Datum');
  const dupError = document.getElementById('date_loc_error');
  const existing = @json($existingDateLocations); // [{date:'YYYY-MM-DD', location:'Amsterdam'}, ...]

  const naam = document.querySelector('input[name="Naam"]');
  const naamCounter = document.getElementById('naam_counter');
  const locCounter  = document.getElementById('loc_counter');
  const opm = document.querySelector('textarea[name="Opmerking"]');
  const opmCounter = document.getElementById('opm_counter');

  function updateHidden(){
    hidden.value = (select.value === '__other') ? (customInput.value || '').trim() : select.value;
    validateDuplicate();
  }

  function showCustomIfNeeded(){
    const isOther = (select.value === '__other');
    customWrap.style.display = isOther ? 'block' : 'none';
    if(isOther) customInput.focus();
  }

  // prevent same date + same location
  function validateDuplicate(){
    dupError.style.display = 'none';
    dateInput.setCustomValidity('');
    const d = (dateInput.value || '').trim();
    const l = (hidden.value || '').trim();
    if(!d || !l) return;

    const clash = existing.some(e => e.date === d && e.location.toLowerCase() === l.toLowerCase());
    if(clash){
      const msg = 'Er bestaat al een event op deze datum en locatie.';
      dupError.textContent = msg;
      dupError.style.display = 'block';
      // attach the error to either field so form can’t submit
      dateInput.setCustomValidity(msg);
    }
  }

  // integer-only hardening for number inputs
  document.querySelectorAll('.block-int-only').forEach(inp => {
    // block e, E, +, -, ., comma
    inp.addEventListener('keydown', (e) => {
      if (['e','E','+','-','.','\',',].includes(e.key)) e.preventDefault();
    });
    // strip non-digits if pasted
    inp.addEventListener('input', () => {
      const cleaned = inp.value.replace(/\D+/g,'');
      if (inp.value !== cleaned) inp.value = cleaned;
      // clamp to [0, 500000]
      const n = Math.min(500000, Math.max(0, Number(inp.value || 0)));
      if (String(n) !== inp.value) inp.value = n;
    });
  });

  // live counters
  function bindCounter(el, counterEl, max){
    const update = () => { counterEl.textContent = (el.value || '').length; };
    el.addEventListener('input', update); update();
  }
  if(naam && naamCounter) bindCounter(naam, naamCounter, 255);
  if(customInput && locCounter) bindCounter(customInput, locCounter, 255);
  if(opm && opmCounter) bindCounter(opm, opmCounter, 255);

  // initialize state
  if(select.value === '__other' || (hidden.value && hidden.value !== '' && !Array.from(select.options).some(o => o.value === hidden.value))){
    select.value = '__other';
    customWrap.style.display = 'block';
    customInput.value = hidden.value;
  }
  updateHidden();

  select.addEventListener('change', () => { showCustomIfNeeded(); updateHidden(); });
  customInput.addEventListener('input', updateHidden);
  dateInput.addEventListener('change', validateDuplicate);
})();
</script>
