@extends('layout.main-2')

@section('title', 'Register')

@section('main')
@if (Auth::check())
    <h1> Logged In! </h1>
@else
<body class="hold-transition login-page">
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <div class="login-box">
        <div class="login-logo">
            <a>Register</a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Register Here</p>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Name">
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
                        @if ($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirm" class="form-control" placeholder="Password Confirmation">
                        @if ($errors->has('password_confirm'))
                            <span class="help-block">{{ $errors->first('password_confirm') }}</span>
                        @endif
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </div>
                </form>

                <p class="mb-0 mt-4">
                    <a href="{{ route('login') }}" class="text-center">Log In</a>
                </p>
            </div>
        </div>
    </div>
</body>
@endif
@endsection
