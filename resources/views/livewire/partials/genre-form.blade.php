<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('genre.name') is-invalid @enderror" id="name" wire:model.defer="genre.name">
                            @error('genre.name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn {{ $editMode ? 'btn-primary' : 'btn-success' }}">
                                @if($editMode)
                                    <i class="fas fa-save mr-2"></i> Update
                                @else
                                    <i class="fas fa-plus mr-2"></i> Add
                                @endif
                            </button>
                            <button type="button" class="btn btn-secondary" wire:click="cancel">
                                <i class="fas fa-times mr-2"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
