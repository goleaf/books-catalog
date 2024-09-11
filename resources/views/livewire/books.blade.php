<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fas fa-book mr-2"></i> {{ $showForm ? 'Book List - ' . ($editMode ? 'Edit' : 'Add new book') : 'Book list' }}</h3>

                @if (!$showForm)
                    <button wire:click="create" class="btn btn-outline-light {{ $showForm && !$editMode ? 'font-weight-bold' : '' }}">
                        <i class="fas fa-plus mr-2"></i> Add new Book
                    </button>
                @endif
            </div>
            <div class="card-body">
                @include('livewire.partials.flash-messages')

                @if ($showForm)
                    @include('livewire.partials.book-form')
                @else

                    @include('livewire.partials.book-list')

                @endif
            </div>
        </div>
    </div>
</div>
