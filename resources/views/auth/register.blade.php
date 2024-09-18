@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4 mt-5">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="fas fa-user-plus mr-2"></i> {{ __('Register') }}
                    </h3>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'auth.store', 'method' => 'POST']) !!}
                    @csrf

                    <div class="mb-3">
                        {!! Form::label('name', __('Name'), ['class' => 'form-label fw-bold']) !!}
                        {!! Form::text('name', old('name'), [
                            'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                            'required',
                            'autocomplete' => 'name',
                            'autofocus',
                        ]) !!}
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        {!! Form::label('email', __('Email Address'), ['class' => 'form-label fw-bold']) !!}
                        {!! Form::email('email', old('email'), [
                            'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
                            'required',
                            'autocomplete' => 'email',
                        ]) !!}
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        {!! Form::label('password', __('Password'), ['class' => 'form-label fw-bold']) !!}
                        {!! Form::password('password', [
                            'class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''),
                            'required',
                            'autocomplete' => 'new-password',
                        ]) !!}
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        {!! Form::label('password_confirmation', __('Confirm Password'), ['class' => 'form-label fw-bold']) !!}
                        {!! Form::password('password_confirmation', [
                            'class' => 'form-control',
                            'required',
                            'autocomplete' => 'new-password',
                        ]) !!}
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        {!! Form::submit(__('Register'), ['class' => 'btn btn-primary']) !!}
                        <a href="{{ route('auth.login') }}" class="btn btn-outline-primary">
                            {{ __('Login') }}
                        </a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
