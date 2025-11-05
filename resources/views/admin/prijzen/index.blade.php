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

</x-layout>
