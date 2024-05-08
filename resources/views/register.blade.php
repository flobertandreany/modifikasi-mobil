@extends('layouts.loginRegisterMain')

@section('content')
    <div class="col-md-6 col-lg-7 d-flex align-items-center">
        <div class="card-body p-4 p-lg-5 text-black">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="d-flex align-items-center justify-content-center mb-3 pb-1">
                    <span class="h1 fw-bold mb-0">REGISTER</span>
                </div>
                <div class="form-outline mb-2 form-floating">
                    <input type="text" name="name" id="name" class="form-control
                    @error('name') is-invalid @enderror" placeholder="Name" required value="{{ old('name') }}"/>
                    <label for="name">Name</label>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-outline mb-2 form-floating">
                    <input type="text" name="username" id="username" class="form-control
                    @error('username') is-invalid @enderror" placeholder="Username" required value="{{ old('username') }}"/>
                    <label for="username">Username</label>
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-outline mb-2 form-floating">
                    <input type="email" name="email" id="email" class="form-control
                    @error('email') is-invalid @enderror" placeholder="name@example.com" required value="{{ old('email') }}"/>
                    <label for="email">Email address</label>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-outline mb-3 form-floating">
                    <input type="password" name="password" id="password" class="form-control
                    @error('password') is-invalid @enderror" placeholder="Password" required/>
                    <label for="password">Password</label>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="pt-1 mb-2">
                    <button class="btn text-light" style="background-color: #F36600;" type="submit">Register</button>
                </div>
                <p class="pb-lg-2" style="color: #5F5F5F;">Already have An Account? <a href="{{ route('view.login') }}" class="text-decoration-none"
                    style="color: #F36600;">Login</a>
                </p>
            </form>
        </div>
    </div>
@endsection
@push('custom_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

    </style>
@endpush
