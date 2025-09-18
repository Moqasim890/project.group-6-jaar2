<x-layout>
    <div>
        <h1>Event Details</h1>
        <p>Here you can find the details of the selected event.</p>
    </div>
    <div>
        <h1>Buy Tickets</h1>
        @foreach($event->days as $day)
            <div class="accordion mb-3" id="accordionDay{{ $day->id }}">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $day->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $day->id }}" aria-expanded="false" aria-controls="collapse{{ $day->id }}">
                            {{ $day->date->format('l, F j, Y') }}
                        </button>
                    </h2>
                    <div id="collapse{{ $day->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $day->id }}" data-bs-parent="#accordionDay{{ $day->id }}">
                        <div class="accordion-body">
                            <p>Tickets available for this day:</p>
                            <form method="POST" action="{{ route('tickets.purchase', ['day' => $day->id]) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="quantity{{ $day->id }}" class="form-label">Quantity</label>
                                    <input type="number" name="quantity" id="quantity{{ $day->id }}" class="form-control" min="1" value="1" required>
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
