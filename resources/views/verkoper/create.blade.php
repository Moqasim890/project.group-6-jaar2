<x-layout>
    @vite(['resources/css/verkopers-style.css'])
    <div class="container d-flex justify-content-center align-items-center mt-4">
        <div class="row">
            <div class="col-12">
                <?php echo "hallo mazin! alles goed?" ?>
                    <form action="" method="POST" class="form-toevoegen-verkoper justify-content-center align-items-center">
                        <h1 class="text-center mt-5">Titel</h1>

                        <div class="mb-3 d-flex justify-content-center">
                            <input name="test1" type="text" placeholder="test">
                        </div>

                        <div class="mb-3 d-flex justify-content-center">
                            <input name="test1" type="text" placeholder="test">
                        </div>

                        <div class="mb-3 d-flex justify-content-center">
                            <input name="test1" type="text" placeholder="test">
                        </div>

                        <div class="mb-3 d-flex justify-content-center">
                            <input name="test1" type="text" placeholder="test">
                        </div>

                        <div class="mb-3 d-flex justify-content-center">
                            <input name="test1" type="text" placeholder="test">
                        </div>

                        <div class=" d-flex justify-content-center">
                            <button type="submit" class="">toevoegen</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</x-layout>