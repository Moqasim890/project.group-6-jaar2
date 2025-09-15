<x-layout>
    <h1 class="text-start align-self-start mb-5 text-2xl font-bold">choose your event</h1>
    <section class="row gap-3 mx-auto">
        {{-- @foreach ($events as $event)
            <x-ticket-card :event="$event" />
        @endforeach --}}
        {{-- <div class="col justify-center align-center">
            <p class="text-center">No events available</p>
        </div> --}}

        <a href="" class="col border-2 border-black rounded-lg p-3 hover:bg-gray-200">
            <h2>Amsterdam</h2>
            <p>Event details go here</p>
        </a>
        <a href="" class="col border-2 border-black rounded-lg p-3 hover:bg-gray-200">
            <h2>Amsterdam</h2>
            <p>Event details go here</p>
        </a>
        <a href="" class="col border-2 border-black rounded-lg p-3 hover:bg-gray-200">
            <h2>Amsterdam</h2>
            <p>Event details go here</p>
        </a>
    </section>
</x-layout>
