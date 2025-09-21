
    <x-layout>
    @vite(['resources/css/verkopers-style.css'])
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <h1 class="page-titel">Alle verkopers</h1>
                <p class="page-tekst">meer info over verkopers is hier te vinden</p>
                <table class="table">
                    <thead>
                        <th scope="col">Naam</th>
                        <th scope="col">Speciale status</th>
                        <th scope="col">Verkoop soort</th>
                        <th scope="col">Stand Type</th>
                        <th scope="col">Dagen</th>
                        <th scope="col">Logo</th>
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