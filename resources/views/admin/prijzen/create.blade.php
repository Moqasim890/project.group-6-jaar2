<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Nieuwe Prijs Toevoegen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col">
                <h1>Nieuwe Prijs Toevoegen</h1>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.prijzen.index') }}" class="btn btn-secondary">
                    Terug naar Overzicht
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.prijzen.store') }}" method="POST" id="prijsForm">
                    @csrf

                    <div class="mb-3">
                        <label for="evenement_id" class="form-label">Evenement *</label>
                        <select name="evenement_id" id="evenement_id" class="form-select @error('evenement_id') is-invalid @enderror" required>
                            <option value="">Selecteer een evenement</option>
                            @foreach($evenements as $evenement)
                                <option value="{{ $evenement->id }}" {{ old('evenement_id') == $evenement->id ? 'selected' : '' }}>
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
                        <input type="date" name="datum" id="datum" class="form-control @error('datum') is-invalid @enderror" value="{{ old('datum') }}" required>
                        @error('datum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tijdslot" class="form-label">Tijdslot *</label>
                        <select name="tijdslot" id="tijdslot" class="form-select @error('tijdslot') is-invalid @enderror" required>
                            <option value="">Selecteer een tijdslot</option>
                            <option value="08:00:00" {{ old('tijdslot') == '08:00:00' ? 'selected' : '' }}>08:00</option>
                            <option value="11:00:00" {{ old('tijdslot') == '11:00:00' ? 'selected' : '' }}>11:00</option>
                            <option value="14:00:00" {{ old('tijdslot') == '14:00:00' ? 'selected' : '' }}>14:00</option>
                        </select>
                        @error('tijdslot')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tarief" class="form-label">Tarief (€) *</label>
                        <input type="number" name="tarief" id="tarief" class="form-control @error('tarief') is-invalid @enderror" value="{{ old('tarief') }}" step="0.01" min="0" required>
                        @error('tarief')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="opmerking" class="form-label">Opmerking</label>
                        <textarea name="opmerking" id="opmerking" class="form-control @error('opmerking') is-invalid @enderror" rows="3">{{ old('opmerking') }}</textarea>
                        @error('opmerking')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Opslaan</button>
                        <a href="{{ route('admin.prijzen.index') }}" class="btn btn-secondary">Annuleren</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2"></i>Gelukt!</h5>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">De ticket is succesvol toegevoegd!</h4>
                    <p class="text-muted">De nieuwe ticketprijs is opgeslagen in het systeem.</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.prijzen.index') }}" class="btn btn-success">OK</a>
                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show error modal if there's a tijdslot error (duplicate)
        @error('tijdslot')
            document.addEventListener('DOMContentLoaded', function() {
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        @enderror
    </script>
</body>
</html>
