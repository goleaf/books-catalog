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
    <main role="main" class="container mt-4">
        @yield('content')
    </main>
</div>

@livewireScripts

@vite('resources/js/app.js')

@stack('scripts')

</body>
</html>
