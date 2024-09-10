@if (session()->has('success') || $errors->any())
    <div class="alert {{ session()->has('success') ? 'alert-success' : 'alert-danger' }} alert-dismissible fade show" role="alert">
        @if (session()->has('success'))
            {{ session('success') }}
        @else
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
