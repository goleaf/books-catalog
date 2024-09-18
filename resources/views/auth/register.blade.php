@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body bg-white">
                        {!! Form::open(['route' => 'auth.store', 'method' => 'POST']) !!}
                        <div class="mb-3 row">
                            {!! Form::label('name', 'Name', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::text('name', old('name'), [
                                    'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                                    'required',
                                    'autocomplete' => 'name',
                                    'autofocus',
                                ]) !!}
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            {!! Form::label('email', 'Email Address', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::email('email', old('email'), [
                                    'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
                                    'required',
                                    'autocomplete' => 'email',
                                ]) !!}
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            {!! Form::label('password', 'Password', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::password('password', [
                                    'class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''),
                                    'required',
                                    'autocomplete' => 'new-password',
                                ]) !!}
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::password('password_confirmation', [
                                    'class' => 'form-control',
                                    'required',
                                    'autocomplete' => 'new-password',
                                ]) !!}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                {!! Form::submit('Register', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
