@if ($users->isEmpty())
    <p>No users found.</p>
@else
    <table class="table table-hover">
        <thead>
        <tr>
            <th class="table-header" wire:click="sortBy('name')">
                Name
                @include('livewire.partials.sort-icon', ['field' => 'name'])
            </th>
            <th class="table-header" wire:click="sortBy('email')">
                Email
                @include('livewire.partials.sort-icon', ['field' => 'email'])
            </th>
            <th class="table-header text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td class="text-end">
                    @can('manage-users') {{- Only show action buttons to admins }}
                    <div class="btn-group" role="group">
                        <button wire:click="edit({{ $user->id }})" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <button wire:click="delete({{ $user->id }})" class="btn btn-danger btn-sm d-flex align-items-center gap-2"
                                onclick="return confirm('Are you sure you want to delete this user?')">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
