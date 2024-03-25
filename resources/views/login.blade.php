<!doctype html>
<html lang="en" data-bs-theme="auto">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Sparecar | Login</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="img/login/Image Login Regis.jpg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                                <img class="position-absolute start-0" style="margin-left: 3rem; margin-top: 2rem;" src="img/login/Logo SpareCar.png" alt="image login" width="250px" height="37px">
                            </div>
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
                                        <p class="mb-3 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="/register"
                                            style="color: #393f81;">Register here</a>
                                        </p>
                                        <a href="{{ route('form.store') }}" style="text-decoration: none; color:#4B4B4B;">
                                            <div class="btn btn-outline-dark">Register As Store</div>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
