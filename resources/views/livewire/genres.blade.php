<div>
    @if ($showForm)
        @include('livewire.partials.genre-form')
    @else
        <button wire:click="create" class="btn btn-primary mb-3">
            <i class="fas fa-plus mr-2"></i> Add New Genre
        </button>

        @include('livewire.partials.genre-list')
    @endif

    @include('livewire.partials.flash-messages')
</div>
