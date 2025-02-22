<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="/assets/css/main/app.css" />
    <link rel="stylesheet" href="/assets/css/pages/auth.css" />
    <link rel="shortcut icon" href="/assets/images/logo/favicon.svg" type="image/x-icon" />
    <link rel="shortcut icon" href="/assets/images/logo/favicon.png" type="image/png" />

</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12" style="display: flex; flex-direction:column; justify-content:center">
                <div id="auth-left">
                    <h1 class="auth-title">Register</h1>
                    <p class="auth-subtitle mb-3">Input your data to register to our website.</p>
                    <form method="POST" action="{{ route('anggota.register.auth') }}">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="nim" type="number"
                                class="form-control @error('nim') is-invalid @enderror form-control-xl" name="nim"
                                value="{{ old('nim') }}" required autocomplete="nim"
                                placeholder="NIM" autofocus>
                            @error('nim')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-control-icon">
                                <i class="bi bi-hash"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="nama" type="text"
                                class="form-control @error('nama') is-invalid @enderror form-control-xl" name="name"
                                value="{{ old('nama') }}" required autocomplete="nama"
                                placeholder="Nama Lengkap" autofocus>
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-control-icon">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror form-control-xl" name="email"
                                value="{{ old('email') }}" required autocomplete="email"
                                placeholder="Email Binus (@binus.ac.id)" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="password" type="password"
                                class="form-control form-control-xl @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password" placeholder="Password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-3" type="submit">
                            Register
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <img src="{{ '/assets/images/samples/perpus.jpg' }}" alt="" style="height: 100%"
                        width="100%">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
