<x-layout>
    <h1 class="text-start align-self-start mb-5 text-2xl font-bold">choose your event</h1>
    <div class="row gap-5" style="width: 100%;">
        @foreach ($evenementen as $event)
            <a href='{{ route("tickets.show", $event) }}' class="card" style="width: 24rem; margin-bottom: 2rem; padding: 1.5rem;">
                <div class="card-body">
                    <h5 class="card-title" style="font-size: 1.75rem;">{{ $event->Naam }}</h5>
                    <p class="card-text" style="font-size: 1.2rem;">{{ $event->Locatie }} - {{ $event->Datum }}</p>
                </div>
            </a>
        @endforeach
    </div>
</x-layout>
