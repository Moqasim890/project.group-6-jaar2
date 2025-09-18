<x-layout>
    <h1 class="text-start align-self-start mb-5 text-2xl font-bold">choose your event</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4 w-100">
        {{-- @foreach ($events as $event) --}}
            {{-- <div class="col">
                <a href="{{ url('/tickets/' . $event->id) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->name }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $event->name }}</h5>
                            <p class="card-text mb-4">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                            <div class="mt-auto">
                                <span class="badge bg-primary">{{ $event->date->format('d M Y') }}</span>
                                <span class="badge bg-secondary">{{ $event->location }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach --}}
    </div>
</x-layout>
