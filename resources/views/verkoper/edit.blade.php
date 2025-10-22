<x-layout>
    @vite(['resources/css/verkopers-style.css'])
    <div class="form-toevoegen-verkoper container d-flex justify-content-center align-items-center mt-5 mb-5 h-100 p-3">
        <div class="col-md-8">
            <h2 class="text-white">{{ $title }}</h2>
            <form method="POST" action="{{ route('verkoper.update', $verkoper) }}">
                @csrf
                <div class="mb-2 justify-content-center">
                    <label for="InputNaam" class="form-label text-white">Naam</label>
                    
                    <input name="Naam" type="text" id="InputNaam" value="{{ old('Naam', $verkoper->Naam) }}"  required>
                </div>
                <div class="mb-2 justify-content-center">
                    <label for="InputSpecialeStatus" class="form-label text-white">speciale status</label>
                    <select name="SpecialeStatus" id="InputSpecialeStatus" required>
                        <option value="{{ old('SpecialeStatus', $verkoper->SpecialeStatus) }}">
                            {{ old('SpecialeStatus', $verkoper->SpecialeStatus) }}
                        </option>
                        <option value="PARTNER">JA</option>
                        <option value="GEEN">NEE</option>
                    </select>
                </div>
                <div class="mb-2 justify-content-center">
                    <label for="InputVerkooptSoort" class="form-label text-white">verkoop soort</label>
                    <select name="VerkooptSoort" id="verkoopt-soort" class="form-select" required>
                        <option value="{{ old('VerkooptSoort', $verkoper->VerkooptSoort) }}">
                            {{ old('VerkooptSoort', $verkoper->VerkooptSoort) }}
                        </option>
                        <option value="SNEAKERS">Sneakers</option>
                        <option value="ETEN_DRINKEN">Eten & Drinken</option>
                        <option value="KIDS_CORNER">Kids Corner</option>
                        <option value="CUSTOMIZERS">Customizers</option>
                        <option value="TATTOO">Tattoo</option>
                        <option value="BARBERSHOP">Barbershop</option>
                        <option value="DJ_SET">DJ Set</option>
                        <option value="OVERIG">Overig</option>
                    </select>
                </div>
                <div class="mb-2 justify-content-center">
                    <label for="InputStandType" class="form-label text-white">Stand Type</label>
                    <select name="StandType" id="InputStandType" class="form-select" required>
                        <option value="{{ old('StandType', $verkoper->StandType) }}">
                            {{ old('StandType', $verkoper->StandType) }}
                        </option>
                        <option value="A">A</option>
                        <option value="AA">AA</option>
                        <option value="AAplus">AA+</option>
                    </select>
                </div>
                <div class="mb-2 justify-content-center">
                    <label for="InputDagen" class="form-label text-white">Aantal Dagen</label>
                    <select name="Dagen" id="InputDagen" class="form-select" required>
                        <option value="{{ old('Dagen', $verkoper->Dagen) }}">
                            {{ old('Dagen', $verkoper->Dagen) }}
                        </option>
                        <option value="EEN">Eén</option>
                        <option value="TWEE">Twee</option>
                    </select>
                </div>
                <div class="mb-2 justify-content-center">
                    <label for="InputLogoUrl" class="form-label text-white">Logo URL</label>
                    <input name="LogoUrl" type="text" id="InputLogoUrl" value="{{ old('LogoUrl', $verkoper->LogoUrl) }}">
                </div>
                <div>
                    @error('Naam')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-4 w-100">Verzend</button>
            </form>
        </div>
    </div>
</x-layout>