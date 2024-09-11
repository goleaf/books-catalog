@if ($genres->isEmpty())
    <p>No genres found.</p>
@else
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($genres as $genre)
            <tr>
                <td>{{ $genre->name }}</td>
                <td class="text-end">
                    <div class="btn-group" role="group">
                        <button wire:click="edit({{ $genre->id }})" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <button wire:click="delete({{ $genre->id }})" class="btn btn-danger btn-sm d-flex align-items-center gap-2"
                                onclick="return confirm('Are you sure you want to delete this genre?')">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
