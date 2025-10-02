<x-layout>
    @vite(['resources/css/verkopers-style.css'])
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center align-items-center" style="height: 100dvh;">
                <div class="form-toevoegen-verkoper">
                    <form action="" method="POST">
                        <h1>Test</h1>
                        <p>bla bla bla</p>
                        <label for="test1">test</label>
                        <input name="test1" type="text" placeholder="test">

                        <label for="test2">test</label>
                        <input name="test2" type="text" placeholder="test">

                        <label for="test3">test</label>
                        <input name="test3" type="text" placeholder="test">
                        
                        <label for="test4">test</label>
                        <input name="test4" type="text" placeholder="test">

                        <label for="test5">test</label>
                        <input name="test5" type="text" placeholder="test">

                        <button type="submit" class="btn btn-succes">toevoegen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>