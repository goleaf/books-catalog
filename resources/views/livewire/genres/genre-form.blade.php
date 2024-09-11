<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['wire:submit.prevent' => $editMode ? 'update' : 'store']) !!}
                    @csrf

                    <div class="mb-3">
                        {!! Form::label('name', __('Name'), ['class' => 'form-label']) !!}
                        {!! Form::text('name', $editMode ? $genre['name'] : null,
                            ['class' => 'form-control' . ($errors->has('genre.name') ? ' is-invalid' : ''), 'required']) !!}
                        @error('genre.name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        {!! Form::submit($editMode ? 'Update' : 'Add', ['class' => 'btn ' . ($editMode ? 'btn-primary' : 'btn-success')]) !!}
                        <button type="button" class="btn btn-secondary" wire:click="cancel">
                            <i class="fas fa-times mr-2"></i> Cancel
                        </button>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
