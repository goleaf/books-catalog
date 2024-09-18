@if ($genres->isEmpty())
    <p>No genres found.</p>
@else
    <table class="table table-hover align-middle table-responsive table-bordered">
        <thead>
            <tr class="filters">
                <td>
                    <input type="text" wire:model.debounce.500ms="searchName" wire:keydown.enter="loadGenres"
                        class="form-control form-control-sm" placeholder="Search by name...">
                    @error('searchName')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <span class="me-2">Number of books:</span>
                        <input type="number" wire:model.defer="filterBooksFrom" wire:keydown.enter="loadGenres"
                            class="form-control form-control-sm me-2" placeholder="From" style="width: 80px;">
                        <input type="number" wire:model.defer="filterBooksTo" wire:keydown.enter="loadGenres"
                            class="form-control form-control-sm" placeholder="To" style="width: 80px;">
                    </div>
                    @error('filterBooksFrom')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('filterBooksTo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </td>
                <td class="text-center">
                    <div class="d-flex align-items-center">
                        <button wire:click="loadGenres" class="btn btn-primary btn-sm me-2">Search</button>
                        @if ($searchName || $filterBooksFrom || $filterBooksTo)
                            <button wire:click="resetFilters" class="btn btn-secondary btn-sm">Reset</button>
                        @endif
                    </div>
                </td>
            </tr>

            <tr>
                <th class="table-header" wire:click="sortBy('name')">
                    Name
                    @include('livewire.partials.sort-icon', ['field' => 'name'])
                </th>
                <th class="table-header" wire:click="sortBy('books_count')">
                    Number of books
                    @include('livewire.partials.sort-icon', ['field' => 'books_count'])
                </th>
                <th class="table-header text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($genres as $genre)
                <tr>
                    <td class="align-middle">{{ $genre->name }}</td>
                    <td class="align-middle text-center">{{ $genre->books_count }}</td>
                    <td class="align-middle text-center">
                        <div class="btn-group" role="group" aria-label="Genre actions">
                            <button wire:click="edit({{ $genre->id }})" class="btn btn-outline-primary btn-sm" title="Edit genre"><i class="fas fa-edit"></i><span class="d-none d-md-inline ms-1">Edit</span></button>
                            <button onclick="confirmDelete({{ $genre->id }}, 'genre')" class="btn btn-outline-danger btn-sm" title="Delete genre"><i class="fas fa-trash-alt"></i><span class="d-none d-md-inline ms-1">Delete</span></button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endif


@push('scripts')
    <script>
        function confirmDelete(id, itemType) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You won't be able to revert this ${itemType} deletion!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit(`delete${itemType.charAt(0).toUpperCase() + itemType.slice(1)}`, id);
                }
            });
        }
    </script>
@endpush
