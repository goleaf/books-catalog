<div>
    @if ($showForm)
        @include('livewire.users.user-form')
    @else
        @can('manage-users')
        <button wire:click="create" class="btn btn-primary mb-3">
            <i class="fas fa-plus mr-2"></i> Add new user
        </button>
        @endcan

        @include('livewire.users.user-list')
    @endif

</div>
