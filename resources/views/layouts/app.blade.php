<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Catalog</title>
    @vite('resources/js/app.js')
    @vite('resources/sass/app.scss')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('books.index') }}">Book Catalog</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('books.create') }}">Add new</a>
                </li>

            </ul>
        </div>
    </nav>

    <main role="main" class="container mt-4">
        @yield('content')
    </main>
</div>

@vite('resources/js/app.js')
</body>
</html>
