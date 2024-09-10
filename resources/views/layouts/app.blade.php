<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Catalog</title>
    @vite('resources/js/app.js')
    @vite('resources/sass/app.scss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @livewireStyles
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('books.index') }}">
                <i class="fas fa-book-open mr-2"></i> Book Catalog
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
{{--
                        <a class="nav-link" href="{{ route('books.create') }}">
                            <i class="fas fa-plus-circle mr-2"></i> Add New
                        </a>
                        --}}
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main role="main" class="container mt-4">
        @yield('content')
    </main>
</div>

@livewireScripts

@vite('resources/js/app.js')
@stack('scripts')

</body>
</html>
