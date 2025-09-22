<x-layout>
    <div>
        <form action="" method="POST" class="mb-5 p-5 rounded shadow bg-white" style="width: 66vw; max-width: 1800px; margin: 0 auto; font-size: 1.3rem;">
            @csrf
            <table class="table table-bordered table-hover align-middle" style="font-size: 1.2rem; width: 100%;">
            <thead class="thead-dark">
            <tr>
            <th colspan="5" class="h2 font-weight-bold text-primary">
                Tickets voor {{ $evenement->Naam }},<br>
                <span class="h5 text-secondary">{{ $evenement->Locatie }}</span>
            </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($prijzen as $dag => $ticketgroup)
            <tr>
                <td colspan="5" class="h4 font-weight-bold bg-light">
                {{ \Carbon\Carbon::parse($dag)->translatedFormat('l d F Y') }}
                </td>
            </tr>
            <tr class="table-secondary">
                <th>Timeslot</th>
                <th>Prijs</th>
                <th>Aantal</th>
            </tr>
            @foreach ($ticketgroup as $ticket)
                <tr>
                <td>{{ $ticket->Tijdslot }}</td>
                <td>&euro; {{ number_format($ticket->Tarief, 2, ',', '.') }}</td>
                <td>
                <input type="number" name="aantal[{{ $ticket->id }}]" min="0" value="0"
                class="form-control w-50 mx-auto text-center" style="font-size: 1.2rem; height: 60px;" />
                </td>
                </tr>
            @endforeach
            @endforeach

            <tr>
            <td colspan="5" class="text-end font-weight-bold h5">
                Totaal aantal geselecteerde tickets:
                <span id="totalTickets" class="badge bg-primary fs-4" style="font-size: 1.3rem;">0</span>
            </td>
            </tr>
            <tr>
            <td colspan="5" class="text-center">
                <button type="submit" class="btn btn-success btn-lg px-5 py-3" style="font-size: 1.3rem;">
                <i class="fas fa-ticket-alt"></i> Bestel tickets
                </button>
            </td>
            </tr>
            </tbody>
            </table>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const inputs = document.querySelectorAll('input[type="number"][name^="aantal"]');
                const totalSpan = document.getElementById('totalTickets');

                function updateTotal() {
                    let total = 0;
                    inputs.forEach(input => {
                        total += parseInt(input.value) || 0;
                    });
                    totalSpan.textContent = total;
                }

                inputs.forEach(input => {
                    input.addEventListener('input', updateTotal);
                });

                updateTotal();
            });
        </script>
    </div>
</x-layout>
