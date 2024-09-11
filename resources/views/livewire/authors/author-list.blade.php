@if ($authors->isEmpty())
    <p>No authors found.</p>
@else
    <table class="table table-hover">
        <thead>
        <tr>
            <th class="table-header" wire:click="sortBy('name')">
                Name
                @include('livewire.partials.sort-icon', ['field' => 'name'])
            </th>
            <th class="table-header text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($authors as $author)
            <tr>
                <td>{{ $author->name }}</td>
                <td class="text-end">
                    <div class="btn-group" role="group">
                        <button wire:click="edit({{ $author->id }})" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <button wire:click="delete({{ $author->id }})" class="btn btn-danger btn-sm d-flex align-items-center gap-2"
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
