
    <x-layout>
    @vite(['resources/css/verkopers-style.css'])
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <h1 class="page-titel">Alle verkopers</h1>
                <p class="page-tekst">meer info over verkopers is hier te vinden</p>
                <a href="/verkoper/create" class="btn btn-success w-25 border-black mb-2">Verkoper Toevoegen +</a>
                {{-- meldingen kunnen beter --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" aria-label="sluiten" data-bs-dismiss="alert"></button>
                    </div>
                    <meta http-equiv="refresh" content="3;url={{ route('verkoper.index') }}">
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" aria-label="sluiten" data-bs-dismiss="alert"></button>
                    </div>
                    <meta http-equiv="refresh" content="3;url={{ route('verkoper.index') }}">
                @endif
                <table class="table">
                    <thead>
                        <th scope="col">Naam</th>
                        <th scope="col">Speciale status</th>
                        <th scope="col">Verkoop soort</th>
                        <th scope="col">Stand Type</th>
                        <th scope="col">Dagen</th>
                        <th scope="col">Logo</th>
                        <th scope="col">Verwijderen</th>
                    </thead>
                    <tbody>
                        @forelse ($verkopers as $verkoper)
                            <tr>
                                <td>{{ $verkoper->Naam }}</td>
                                <td>{{ $verkoper->SpecialeStatus }}</td>
                                <td>{{ $verkoper->VerkooptSoort }}</td>
                                <td>{{ $verkoper->StandType }}</td>
                                <td>{{ $verkoper->Dagen }}</td>
                                <td>
                                    @if($verkoper->LogoUrl)
                                        <img class="logo-verkoper" src="{{ $verkoper->LogoUrl }}" alt="Logo">
                                    @else
                                        geen logo
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('verkoper.destroy', $verkoper->id) }}" method="POST" 
                                          onsubmit="return confirm('weet je zeker dat je {{ $verkoper->Naam }} wilt verwijderen?')">
                                        {{-- csrf = Cross Site Request Forgery --}}
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td style="color: red">Er zijn op dit moment nog geen verkopers</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>