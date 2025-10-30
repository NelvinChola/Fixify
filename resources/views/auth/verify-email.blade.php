@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <p>A verification email with your login credentials has been sent to your email address.</p>
                        <p>Please check your email and click the verification link to activate your account.</p>
                    </div>

                    <p>If you did not receive the email, you can request another one:</p>
                    
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection