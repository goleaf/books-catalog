@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4 mt-5">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="fas fa-sign-in-alt mr-2"></i> {{ __('Login') }}
                    </h3>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'auth.authenticate', 'method' => 'POST']) !!}
                    @csrf

                    <div class="mb-3">
                        {!! Form::label('email', __('Email Address'), ['class' => 'form-label fw-bold']) !!}
                        {!! Form::email('email', old('email'), [
                            'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
                            'required',
                            'autocomplete' => 'email',
                            'autofocus',
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
                            'autocomplete' => 'current-password',
                        ]) !!}
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        {!! Form::checkbox('remember', 1, old('remember'), ['class' => 'form-check-input', 'id' => 'remember']) !!}
                        {!! Form::label('remember', __('Remember Me'), ['class' => 'form-check-label']) !!}
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        {!! Form::submit(__('Login'), ['class' => 'btn btn-primary']) !!}
                        <a href="{{ route('auth.register') }}" class="btn btn-outline-primary">
                            {{ __('Register') }}
                        </a>
                    </div>

     

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
