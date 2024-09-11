<div>
    {!! Form::open(['wire:submit.prevent' => 'login']) !!}

    <div class="mb-3">
        {!! Form::label('email', 'Email', ['class' => 'form-label']) !!}
        {!! Form::email('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'required']) !!}
        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        {!! Form::label('password', 'Password', ['class' => 'form-label']) !!}
        {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'required']) !!}
        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3 form-check">
        {!! Form::checkbox('remember', 1, null, ['class' => 'form-check-input', 'id' => 'remember', 'wire:model' => 'remember']) !!}
        {!! Form::label('remember', 'Remember Me', ['class' => 'form-check-label']) !!}
    </div>

    {!! Form::submit('Login', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
</div>
