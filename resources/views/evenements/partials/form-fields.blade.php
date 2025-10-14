<div class="mb-3">
  <label class="form-label">Naam</label>
  <input name="Naam" value="{{ old('Naam', $model->Naam ?? '') }}" required class="form-control" />
  @error('Naam') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
</div>

<div class="row mb-3">
  <div class="col-sm-6">
    <label class="form-label">Datum</label>
    <input type="date" name="Datum" value="{{ old('Datum', $model->Datum ?? '') }}" required class="form-control" />
    @error('Datum') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>
  <div class="col-sm-6">
    <label class="form-label">Locatie</label>
    <input name="Locatie" value="{{ old('Locatie', $model->Locatie ?? '') }}" required class="form-control" />
    @error('Locatie') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>
</div>

<div class="row mb-3">
  <div class="col-sm-6">
    <label class="form-label">Tickets per tijdslot</label>
    <input type="number" min="0" name="AantalTicketsPerTijdslot" value="{{ old('AantalTicketsPerTijdslot', $model->AantalTicketsPerTijdslot ?? '') }}" required class="form-control" />
    @error('AantalTicketsPerTijdslot') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>
  <div class="col-sm-6">
    <label class="form-label">Beschikbare stands</label>
    <input type="number" min="0" name="BeschikbareStands" value="{{ old('BeschikbareStands', $model->BeschikbareStands ?? '') }}" required class="form-control" />
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
  <textarea name="Opmerking" rows="3" class="form-control">{{ old('Opmerking', $model->Opmerking ?? '') }}</textarea>
  @error('Opmerking') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
</div>