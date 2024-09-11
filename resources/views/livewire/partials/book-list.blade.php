@if ($books->isEmpty())
    <p>No books found.</p>
@else
    <table class="table table-hover">
        <thead>
        <tr class="filters">
            <td>
                <input type="text" wire:model.debounce.500ms="searchTitle" class="form-control form-control-sm" placeholder="Search by title...">
            </td>
            <td>
                <input type="text" wire:model.debounce.500ms="searchAuthor" class="form-control form-control-sm" placeholder="Search by author...">
            </td>
            <td>
                <input type="text" wire:model.debounce.500ms="searchIsbn" class="form-control form-control-sm" placeholder="Search by ISBN...">
            </td>
            <td>
                <div class="d-flex flex-column">
                    <input type="date" wire:model.defer="filterPublicationDateFrom" class="form-control form-control-sm mt-1" placeholder="From...">
                    <input type="date" wire:model.defer="filterPublicationDateTo" class="form-control form-control-sm mt-1" placeholder="To...">
                </div>
            </td>
            <td>
                <select wire:model="filterGenre" class="form-select form-select-sm">
                    <option value="">All Genres</option>
                    @foreach($genres as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <div class="d-flex flex-column">
                    <input type="number" wire:model.defer="filterCopiesFrom" class="form-control form-control-sm mt-1" placeholder="From...">
                    <input type="number" wire:model.defer="filterCopiesTo" class="form-control form-control-sm mt-1" placeholder="To...">
                </div>
            </td>
            <td class="text-center">
                <div class="d-flex align-items-center">
                    <button wire:click="loadBooks" class="btn btn-primary btn-sm me-2">Search</button>
                    @if($searchTitle || $searchAuthor || $searchIsbn || $filterGenre || $filterCopiesFrom || $filterCopiesTo || $filterPublicationDateFrom || $filterPublicationDateTo)
                        <button wire:click="resetFilters" class="btn btn-secondary btn-sm">Reset</button>
                    @endif
                </div>
            </td>
        </tr>

        <tr>
            <th class="table-header" wire:click="sortBy('title')">
                Title
                @include('livewire.partials.sort-icon', ['field' => 'title'])
            </th>
            <th class="table-header" wire:click="sortBy('author')">
                Author
                @include('livewire.partials.sort-icon', ['field' => 'author'])
            </th>
            <th class="table-header" wire:click="sortBy('isbn')">
                ISBN
                @include('livewire.partials.sort-icon', ['field' => 'isbn'])
            </th>
            <th class="table-header" wire:click="sortBy('publication_date')">
                Publication date
                @include('livewire.partials.sort-icon', ['field' => 'publication_date'])
            </th>
            <th class="table-header" wire:click="sortBy('genre')">
                Genre
                @include('livewire.partials.sort-icon', ['field' => 'genre'])
            </th>
            <th class="table-header" wire:click="sortBy('number_of_copies')">
                Number of copies
                @include('livewire.partials.sort-icon', ['field' => 'number_of_copies'])
            </th>
            <th class="table-header text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->isbn }}</td>
                <td>{{ $book->publication_date }}</td>
                <td>{{ $book->genre }}</td>
                <td>{{ $book->number_of_copies }}</td>
                <td class="text-end">
                    <div class="btn-group" role="group">
                        <button wire:click="edit({{ $book->id }})" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <button wire:click="delete({{ $book->id }})" class="btn btn-danger btn-sm d-flex align-items-center gap-2"
                                onclick="return confirm('Are you sure you want to delete this book?')">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
