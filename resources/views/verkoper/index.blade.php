
    <x-layout>
    @vite(['resources/css/verkopers-style.css'])
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <h1 class="page-titel">Alle verkopers</h1>
                <p class="page-tekst">meer info over verkopers is hier te vinden</p>
                <a href="/verkoper/create" id="add-verkoper">Verkoper Toevoegen +</a>
                
                <table class="table">
                    <thead>
                        <th scope="col">Naam</th>
                        <th scope="col">Speciale status</th>
                        <th scope="col">Verkoop soort</th>
                        <th scope="col">Stand Type</th>
                        <th scope="col">Dagen</th>
                        <th scope="col">Logo</th>
                    </thead>
                    <tbody>
                        @forelse ($verkopers as $verkoper)
                            <tr>
                                <td>{{ $verkoper->Naam }}</td>
                                <td>{{ $verkoper->SpecialeStatus }}</td>
                                <td>{{ $verkoper->VerkooptSoort }}</td>
                                <td>{{ $verkoper->StandType }}</td>
                                <td>{{ $verkoper->Dagen }}</td>
                                <td>
                                    @if($verkoper->LogoUrl)
                                        <img class="logo-verkoper" src="{{ $verkoper->LogoUrl }}" alt="Logo">
                                    @else
                                        geen logo
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <td style="color: red">Er zijn op dit moment nog geen verkopers</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    @if(session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2"></i>Gelukt!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">{{ session('success') }}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            @endif
        });
    </script>
    @endpush
</x-layout>