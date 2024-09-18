@if ($users->isEmpty())
    <p>No users found.</p>
@else
    <table class="table table-hover align-middle table-responsive table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="align-middle">{{ $user->name }}</td>
                    <td class="align-middle">{{ $user->email }}</td>
                    <td class="align-middle text-center">
                        <div class="btn-group" role="group" aria-label="User actions">
                            <button wire:click="edit({{ $user->id }})" class="btn btn-outline-primary btn-sm" title="Edit user"><i class="fas fa-edit"></i><span class="d-none d-md-inline ms-1">Edit</span></button>
                            <button onclick="confirmDelete({{ $user->id }}, 'user')" class="btn btn-outline-danger btn-sm" {{ $user->id === auth()->id() ? 'disabled' : '' }} title="{{ $user->id === auth()->id() ? 'You cannot delete your own account' : 'Delete user' }}"><i class="fas fa-trash-alt"></i><span class="d-none d-md-inline ms-1">Delete</span></button>
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
