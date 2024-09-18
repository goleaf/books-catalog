<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Catalog</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('books.index') }}">
                <i class="fas fa-book-open me-2"></i> Book Catalog
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('books.index') }}">
                                <i class="fas fa-book me-2"></i> Books
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('authors.index') }}">
                                <i class="fas fa-user-edit me-2"></i> Authors
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('genres.index') }}">
                                <i class="fas fa-tags me-2"></i> Genres
                            </a>
                        </li>
                        @can('manage-users')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('users.index') }}">
                                    <i class="fas fa-users me-2"></i> Users
                                </a>
                            </li>
                        @endcan
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login') }}">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.register') }}">
                                <i class="fas fa-user-plus me-2"></i> Register
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main role="main" class="container-fluid flex-grow-1">

        @if (session()->has('message'))
            <div class="row justify-content-center text-center mt-3">
                <div class="col-md-8">
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')

    </main>

    <footer class="bg-light py-3 mt-auto shadow-sm">
        <div class="container-fluid text-center">
            <p class="mb-0">&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </footer>

    @livewireScripts
    @vite('resources/js/app.js')
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.hook('component.initialized', (component) => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            Livewire.hook('message.processed', (message, component) => {
                if (document.querySelector('.alert') || component.fingerprint.name === 'books' || component
                    .fingerprint.name === 'authors' || component.fingerprint.name === 'genres') {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>

</html>
