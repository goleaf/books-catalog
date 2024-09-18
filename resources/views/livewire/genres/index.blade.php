<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="fas fa-tags mr-2"></i>
                    {{ $showForm ? 'Genre - ' . ($editMode ? 'Edit' : 'Add new genre') : 'Genre ' }}
                </h3>

                @if (!$showForm)
                    <button wire:click="create"
                        class="btn btn-outline-light {{ $showForm && !$editMode ? 'font-weight-bold' : '' }}">
                        <i class="fas fa-plus mr-2"></i> Add new genre
                    </button>
                @endif
            </div>
            <div class="card-body">

                @include('livewire.partials.flash-messages')

                @if ($showForm)
                    @include('livewire.genres.genre-form')
                @else
                    @include('livewire.genres.genre-list')
                @endif

            </div>
        </div>
    </div>
</div>
