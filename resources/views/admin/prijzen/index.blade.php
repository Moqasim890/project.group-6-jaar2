<x-layout>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col">
                <h1>Prijzen Beheer</h1>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.prijzen.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Nieuwe Prijs Toevoegen
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Evenement</th>
                            <th>Datum</th>
                            <th>Tijdslot</th>
                            <th>Tarief (€)</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prijzen as $prijs)
                            <tr>
                                <td>{{ $prijs->EventNaam }}</td>
                                <td>{{ date('d-m-Y', strtotime($prijs->Datum)) }}</td>
                                <td>{{ substr($prijs->Tijdslot, 0, 5) }}</td>
                                <td>€{{ number_format($prijs->Tarief, 2, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('admin.prijzen.edit', $prijs->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Bewerken
                                    </a>
                                    <form action="{{ route('admin.prijzen.destroy', $prijs->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Weet je zeker dat je deze prijs wilt verwijderen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Verwijderen
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Geen prijzen gevonden.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
                    <h4 class="mt-3" id="successMessage">{{ session('success') }}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Fout</h5>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-x-circle text-danger" style="font-size: 4rem;"></i>
                    <h4 class="mt-3" id="errorMessage">{{ session('error') }}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show success modal if there's a success message
            @if(session('success'))
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            @endif

            // Show error modal if there's an error message
            @if(session('error'))
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            @endif
        });
    </script>
    @endpush
</x-layout>
