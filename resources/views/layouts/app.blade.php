<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Catalog</title>
    @vite('resources/js/app.js')
    @vite('resources/sass/app.scss')
    @livewireStyles
</head>
<body>

    <div id="app">

                <div class="container mt-4">
                    <div class="row justify-content-center">
                        <div class="col-9">
                            <div class="alert alert-danger fade show text-center mt-4" role="alert">
                                <strong>System is under development now</strong>
                                <br> The developer is currently actively working on this system.
                                <br> You may experience some errors or unexpected behavior.
                                <br> When this message is no longer displayed, the developer has completed the tasks and is attending to other matters.
                            </div>
                        </div>
                    </div>
                </div>


        <main role="main" class="container-fluid mt-4">
            @yield('content')
        </main>
    </div>

@livewireScripts

@vite('resources/js/app.js')

@stack('scripts')

</body>
</html>
