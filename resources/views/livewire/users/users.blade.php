<div>
    @if ($showForm)
        @include('livewire.partials.user-form')
    @else
        <button wire:click="create" class="btn btn-primary mb-3">
            <i class="fas fa-plus mr-2"></i> Add New User
        </button>

        @include('livewire.partials.user-list')
    @endif

    @include('livewire.partials.flash-messages')
</div>


