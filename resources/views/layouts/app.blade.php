<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Catalog</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
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
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('books.index') }}">
                                <i class="fas fa-book mr-2"></i> Books
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('authors.index') }}">
                                <i class="fas fa-user-edit mr-2"></i> Authors
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('genres.index') }}">
                                <i class="fas fa-tags mr-2"></i> Genres
                            </a>
                        </li>
                        @can('manage-users')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('users.index') }}">
                                    <i class="fas fa-users mr-2"></i> Users
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a class="nav-link" href="#" wire:click="logout">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login') }}">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.register') }}">
                                <i class="fas fa-user-plus mr-2"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main role="main" class="container mt-4">

        @if (session()->has('message'))
            <div class="row justify-content-center text-center mt-3">
                <div class="col-md-8">
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        @endif

        @yield('content')

    </main>
</div>

@livewireScripts

@vite('resources/js/app.js')
@stack('scripts')

</body>
</html>
