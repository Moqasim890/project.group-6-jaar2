<x-layout>
    <h1 class="text-start align-self-start mb-5 text-2xl font-bold">choose your event</h1>
    <div class="row gap-5" style="width: 100%;">
        @foreach ($evenementen as $event)
            <a href='{{ route("tickets.show", $event) }}' class="card" style="width: 18rem;">
                <img src="https://placehold.co/300" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $event->Naam }}</h5>
                    <p class="card-text">{{ $event->Locatie }}-{{ $event->Datum }}</p>
                </div>
            </a>
        @endforeach
    </div>
</x-layout>
