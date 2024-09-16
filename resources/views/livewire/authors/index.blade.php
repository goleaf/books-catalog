<div>
    @if ($showForm)
        @include('livewire.partials.author-form')
    @else
        <button wire:click="create" class="btn btn-primary mb-3">
            <i class="fas fa-plus mr-2"></i> Add new author
        </button>

        @include('livewire.partials.author-list')
    @endif

</div>
