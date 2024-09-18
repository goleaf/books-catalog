@if ($authors->isEmpty())
    <p>No authors found.</p>
@else
    <table class="table table-hover align-middle table-responsive table-bordered">
        <thead>
            <tr class="filters">
                <td>
                    <input type="text" wire:model.debounce.500ms="searchName" wire:keydown.enter="loadAuthors"
                        class="form-control form-control-sm" placeholder="Search by name...">
                    @error('searchName')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <span class="me-2">Number of Books:</span>
                        <input type="number" wire:model.defer="filterBooksFrom" wire:keydown.enter="loadAuthors"
                            class="form-control form-control-sm me-2" placeholder="From" style="width: 80px;">
                        <input type="number" wire:model.defer="filterBooksTo" wire:keydown.enter="loadAuthors"
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
                        <button wire:click="loadAuthors" class="btn btn-primary btn-sm me-2">Search</button>
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
            @foreach ($authors as $author)
                <tr>
                    <td>{{ $author->name }}</td>
                    <td>{{ $author->books_count }}</td>
                    <td class="text-end">
                        <div class="btn-group" role="group">
                            <button wire:click="edit({{ $author->id }})"
                                class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <button wire:click="delete({{ $author->id }})"
                                class="btn btn-danger btn-sm d-flex align-items-center gap-2"
                                onclick="return confirm('Are you sure you want to delete this author?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endif
