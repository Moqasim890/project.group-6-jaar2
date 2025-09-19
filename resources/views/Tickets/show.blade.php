<x-layout>
    <div>
        <h1>Event Details</h1>
        <p>Here you can find the details of the selected event.</p>
        @foreach($prices as $date => $priceGroup)
            <div class="accordion mb-3" id="accordionDay{{ $date }}">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $date }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $date }}" aria-expanded="false" aria-controls="collapse{{ $date }}">
                            {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}
                        </button>
                    </h2>
                    <div id="collapse{{ $date }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $date }}" data-bs-parent="#accordionDay{{ $date }}">
                        <div class="accordion-body">
                            <p>Tickets available for this day:</p>
                            <form method="POST" action="{{ route('tickets.index', ['day' => $date]) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="quantity{{ $date }}" class="form-label">Quantity</label>
                                    <input type="number" name="quantity" id="quantity{{ $date }}" class="form-control" min="1" value="1" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Buy Ticket</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
                </div>
            </div>
    </div>
</x-layout>
