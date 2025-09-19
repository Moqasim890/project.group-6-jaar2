<x-layout>
    <div>
        <h1>Event Details</h1>
        <p>Here you can find the details of the selected event.</p>
    </div>
    <div>
        <h1>Buy Tickets</h1>
        @foreach($prijzen as $datum => $prijsGroep)
            <div class="accordion mb-3" id="accordionDay{{ $datum }}">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $datum }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $datum }}" aria-expanded="false" aria-controls="collapse{{ $datum }}">
                            {{ \Carbon\Carbon::parse($datum)->format('l, F j, Y') }}
                        </button>
                    </h2>
                    <div id="collapse{{ $datum }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $datum }}" data-bs-parent="#accordionDay{{ $datum }}">
                        <div class="accordion-body">
                            <p>Tickets available for this day:</p>
                            <form method="POST" action="{{ route('tickets.index', ['day' => $datum]) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="quantity{{ $datum }}" class="form-label">Quantity</label>
                                    <input type="number" name="quantity" id="quantity{{ $datum }}" class="form-control" min="1" value="1" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Buy Ticket</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layout>
