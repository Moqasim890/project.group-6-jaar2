<x-layout>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col">
                <h1>Prijs Bewerken</h1>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.prijzen.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Terug naar Overzicht
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.prijzen.update', $prijs->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="evenement_id" class="form-label">Evenement *</label>
                        <select name="evenement_id" id="evenement_id" class="form-select @error('evenement_id') is-invalid @enderror" required>
                            <option value="">Selecteer een evenement</option>
                            @foreach($evenements as $evenement)
                                <option value="{{ $evenement->id }}"
                                    {{ (old('evenement_id', $prijs->EvenementId) == $evenement->id) ? 'selected' : '' }}>
                                    {{ $evenement->Naam }}
                                </option>
                            @endforeach
                        </select>
                        @error('evenement_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="datum" class="form-label">Datum *</label>
                        <input type="date" name="datum" id="datum"
                               class="form-control @error('datum') is-invalid @enderror"
                               value="{{ old('datum', $prijs->Datum) }}"
                               min="{{ date('Y-m-d') }}"
                               required>
                        @error('datum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tijdslot" class="form-label">Tijdslot *</label>
                        <select name="tijdslot" id="tijdslot" class="form-select @error('tijdslot') is-invalid @enderror" required>
                            <option value="">Selecteer een tijdslot</option>
                            <option value="08:00:00" {{ old('tijdslot', substr($prijs->Tijdslot, 0, 5)) == '08:00' ? 'selected' : '' }}>08:00</option>
                            <option value="11:00:00" {{ old('tijdslot', substr($prijs->Tijdslot, 0, 5)) == '11:00' ? 'selected' : '' }}>11:00</option>
                            <option value="14:00:00" {{ old('tijdslot', substr($prijs->Tijdslot, 0, 5)) == '14:00' ? 'selected' : '' }}>14:00</option>
                        </select>
                        @error('tijdslot')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tarief" class="form-label">Tarief (€) *</label>
                        <input type="number" name="tarief" id="tarief"
                               class="form-control @error('tarief') is-invalid @enderror"
                               value="{{ old('tarief', $prijs->Tarief) }}"
                               step="0.01"
                               min="0.01"
                               required>
                        @error('tarief')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="is_actief" class="form-label">Status *</label>
                        <select name="is_actief" id="is_actief" class="form-select @error('is_actief') is-invalid @enderror" required>
                            <option value="1" {{ old('is_actief', $prijs->IsActief) == 1 ? 'selected' : '' }}>Actief</option>
                            <option value="0" {{ old('is_actief', $prijs->IsActief) == 0 ? 'selected' : '' }}>Inactief</option>
                        </select>
                        @error('is_actief')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="opmerking" class="form-label">Opmerking</label>
                        <textarea name="opmerking" id="opmerking" class="form-control @error('opmerking') is-invalid @enderror" rows="3">{{ old('opmerking', $prijs->Opmerking) }}</textarea>
                        @error('opmerking')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Opslaan
                        </button>
                        <a href="{{ route('admin.prijzen.index') }}" class="btn btn-secondary">Annuleren</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Error Modal (Duplicate) -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Fout</h5>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-x-circle text-danger" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">De ticket bestaat al!</h4>
                    <p class="text-muted">Er bestaat al een prijs voor dit evenement op deze datum en dit tijdslot.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Show error modal if there's a tijdslot error (duplicate)
        @error('tijdslot')
            document.addEventListener('DOMContentLoaded', function() {
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        @enderror
    </script>
    @endpush
</x-layout>
