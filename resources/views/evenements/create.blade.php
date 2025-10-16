<x-layout>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card shadow-sm border-2 border-pink-200 rounded-3xl">
          <div class="card-body">
            <h1 class="mb-4 h4 fw-bold text-pink-700">Nieuw evenement aanmaken</h1>

            {{-- Succesmelding --}}
            @if(session('ok'))
              <div class="alert alert-success">{{ session('ok') }}</div>
            @endif

            {{-- Foutmeldingen --}}
            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" action="{{ route('evenements.store') }}">
              @csrf

              <div class="mb-3">
                <label class="form-label fw-semibold">Naam evenement</label>
                <input name="Naam" value="{{ old('Naam') }}" required class="form-control rounded-2xl border-pink-300" placeholder="Bijvoorbeeld Sneakerness Rotterdam" />
                @error('Naam') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
              </div>

              <div class="row mb-3">
                <div class="col-sm-6">
                  <label class="form-label fw-semibold">Datum</label>
                  <input type="date" name="Datum" value="{{ old('Datum') }}" required class="form-control rounded-2xl border-pink-300" />
                  @error('Datum') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-sm-6">
                  <label class="form-label fw-semibold">Locatie</label>
                  <input name="Locatie" value="{{ old('Locatie') }}" required class="form-control rounded-2xl border-pink-300" placeholder="Bijvoorbeeld Rotterdam" />
                  @error('Locatie') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-6">
                  <label class="form-label fw-semibold">Tickets per tijdslot</label>
                  <input type="number" min="0" name="AantalTicketsPerTijdslot" value="{{ old('AantalTicketsPerTijdslot') }}" required class="form-control rounded-2xl border-pink-300" placeholder="Aantal tickets" />
                  @error('AantalTicketsPerTijdslot') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-sm-6">
                  <label class="form-label fw-semibold">Beschikbare stands</label>
                  <input type="number" min="0" name="BeschikbareStands" value="{{ old('BeschikbareStands') }}" required class="form-control rounded-2xl border-pink-300" placeholder="Aantal stands" />
                  @error('BeschikbareStands') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
              </div>

              {{-- Hidden field: IsActief altijd 1 --}}
              <input type="hidden" name="IsActief" value="1" />

              <div class="mb-3">
                <label class="form-label fw-semibold">Opmerking</label>
                <textarea name="Opmerking" rows="3" class="form-control rounded-2xl border-pink-300" placeholder="Extra informatie">{{ old('Opmerking') }}</textarea>
                @error('Opmerking') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
              </div>

              <div class="d-flex gap-2 mt-4">
                <a href="{{ route('evenements.index') }}" class="btn btn-outline-secondary rounded-2xl px-4">Annuleren</a>
                <button class="btn btn-pink fw-semibold rounded-2xl px-4" style="background-color:#ec4899; color:white;">Opslaan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-layout>
