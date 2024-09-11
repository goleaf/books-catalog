<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['wire:submit.prevent' => $editMode ? 'update' : 'store']) !!}
                    @csrf

                    <div class="mb-3">
                        {!! Form::label('name', __('Name'), ['class' => 'form-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('user.name') ? ' is-invalid' : ''), 'wire:model.defer' => 'user.name', 'required']) !!}
                        @error('user.name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        {!! Form::label('email', __('Email'), ['class' => 'form-label']) !!}
                        {!! Form::email('email', null, ['class' => 'form-control' . ($errors->has('user.email') ? ' is-invalid' : ''), 'wire:model.defer' => 'user.email', 'required']) !!}
                        @error('user.email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    @if (!$editMode)
                        <div class="mb-3">
                            {!! Form::label('password', __('Password'), ['class' => 'form-label']) !!}
                            {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'required']) !!}
                            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            {!! Form::label('password_confirmation', __('Confirm Password'), ['class' => 'form-label']) !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
                        </div>
                    @endif
                    @can('manage-users')
                        <div class="mb-3 form-check">
                            {!! Form::checkbox('is_admin', 1, null, ['class' => 'form-check-input', 'wire:model.defer' => 'user.is_admin']) !!}
                            {!! Form::label('is_admin', 'Is Admin', ['class' => 'form-check-label']) !!}
                        </div>
                    @endcan

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
