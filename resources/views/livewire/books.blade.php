<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-book mr-2"></i> Book List</h3>
                </div>
                <div class="card-body">

                    @include('livewire.partials.flash-messages')

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-target="#addBookModal">
                        <i class="fas fa-plus mr-2"></i> Add new book
                    </button>

                    @include('livewire.partials.book-list')

                    @include('livewire.partials.book-form-modal')

                </div>
            </div>
        </div>
    </div>
</div>
