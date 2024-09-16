<div>
    @if ($showForm)
        @include('livewire.genres.genre-form')
    @else
        <button wire:click="create" class="btn btn-primary mb-3">
            <i class="fas fa-plus mr-2"></i> Add New Genre
        </button>

        @include('livewire.genres.genre-list')
    @endif

</div>
