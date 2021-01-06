@extends('layouts.app')
@section('title')
    Verification
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify the code to activated account') }}</div>
                @if (session('alert'))
                <div class="alert alert-danger">
                  {{ session('alert') }}
                </div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ url('otp') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Verification Code') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="number" class="form-control @error('code') is-invalid @enderror" name="code" required autocomplete="current-password">
                                @if (session('alert'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ session('alert') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a class="btn btn-link" href="{{ url('otp') }}">{{ __('Resend Code') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
