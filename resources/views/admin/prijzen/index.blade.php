{{-- 
    Admin Prijzen Overzicht Pagina
    
    Deze pagina toont alle actieve ticket prijzen in een overzichtstabel voor admin gebruikers.
    
    Functionaliteit:
    - Overzicht van alle actieve prijzen met evenement informatie
    - Datum formatting (dd-mm-yyyy)
    - Tijdslot weergave (HH:MM)
    - Tarief formatting met euro symbool en decimalen
    - Bewerk knop per prijs (wijzigt naar edit view)
    - Verwijder knop per prijs met bevestigingsdialog
    - Knop om nieuwe prijs toe te voegen (gaat naar create view)
    - Empty state bericht als geen prijzen beschikbaar zijn
    
    Data vereist:
    - $prijzen: Collectie van prijs objecten met eigenschappen:
        * id: Prijs ID voor edit/delete acties
        * EventNaam: Naam van gekoppeld evenement
        * Datum: Datum in database formaat (YYYY-MM-DD)
        * Tijdslot: Tijdslot in database formaat (HH:MM:SS)
        * Tarief: Prijs als decimaal getal
    
    Routes gebruikt:
    - admin.prijzen.create: Navigatie naar formulier nieuwe prijs
    - admin.prijzen.edit: Navigatie naar bewerk formulier (parameter: id)
    - admin.prijzen.destroy: DELETE actie voor verwijderen (parameter: id)
--}}
<x-layout>
    <div class="container mt-5">
        {{-- Header sectie met titel en actie knop --}}
        <div class="row mb-4">
            <div class="col">
                <h1>Prijzen Beheer</h1>
            </div>
            <div class="col text-end">
                {{-- Knop naar formulier voor nieuwe prijs --}}
                <a href="{{ route('admin.prijzen.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Nieuwe Prijs Toevoegen
                </a>
            </div>
        </div>

        {{-- Prijzen overzicht tabel --}}
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
                        {{-- Loop door alle prijzen, toon empty state als geen prijzen --}}
                        @forelse($prijzen as $prijs)
                            <tr>
                                {{-- Toon evenement naam --}}
                                <td>{{ $prijs->EventNaam }}</td>
                                
                                {{-- Formatteer datum naar Nederlands formaat (dd-mm-yyyy) --}}
                                <td>{{ date('d-m-Y', strtotime($prijs->Datum)) }}</td>
                                
                                {{-- Toon alleen uren en minuten van tijdslot (HH:MM) --}}
                                <td>{{ substr($prijs->Tijdslot, 0, 5) }}</td>
                                
                                {{-- Formatteer tarief met euro symbool en 2 decimalen --}}
                                <td>€{{ number_format($prijs->Tarief, 2, ',', '.') }}</td>
                                
                                {{-- Actie knoppen voor bewerken en verwijderen --}}
                                <td>
                                    {{-- Bewerk knop navigeert naar edit view --}}
                                    <a href="{{ route('admin.prijzen.edit', $prijs->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Bewerken
                                    </a>
                                    
                                    {{-- Verwijder formulier met JavaScript bevestigingsmelding --}}
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
                            {{-- Toon deze rij als de prijzen collectie leeg is --}}
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
