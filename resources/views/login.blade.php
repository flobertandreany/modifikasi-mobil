@extends('layouts.loginRegisterMain')

@section('content')
    <div class="col-md-6 col-lg-7 d-flex align-items-center">
        <div class="card-body p-4 p-lg-5 text-black">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session()->has('loginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('loginError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <div class="d-flex align-items-center justify-content-center mb-3 pb-1">
                    <span class="h1 fw-bold mb-0">LOGIN</span>
                </div>
                <div class="form-outline mb-2 form-floating">
                    <input type="email" name="email" id="email" class="form-control
                    @error('email') is-invalid @enderror" placeholder="name@example.com" required value="{{ old('email') }}" autofocus/>
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
                <div class="pt-1 mb-4">
                    <button class="btn text-light" style="background-color: #F36600;" type="submit">Log In</button>
                </div>
                <p class="mb-3 pb-lg-2" style="color: #5F5F5F;">Don't have An Account? <a href="/register"
                    style="text-decoration: none; color: #F36600;">Register</a>
                </p>
                <a href="{{ route('form.store') }}">
                    <div class="btn btn-outline-light">Register As Store</div>
                </a>
            </form>
        </div>
    </div>
@endsection
