@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center py-4 rounded-top">
                    <h3 class="fw-bold mb-0"><i class="bi bi-scissors me-2"></i>Lhyna Collection</h3>
                    <p class="small mb-0 opacity-75">Silakan login untuk melanjutkan</p>
                </div>

                <div class="card-body p-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Input Email --}}
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-muted small text-uppercase">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Masukkan email anda...">
                            </div>
                            @error('email')
                                <span class="text-danger small mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Input Password --}}
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-muted small text-uppercase">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan password...">
                            </div>
                            @error('password')
                                <span class="text-danger small mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Remember Me & Forgot Password --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small text-muted" for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link btn-sm text-decoration-none" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>

                        {{-- Tombol Login --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-2"></i> MASUK SEKARANG
                            </button>
                        </div>
                        
                        {{-- Link Daftar --}}
                        <div class="text-center mt-4">
                            <p class="small text-muted mb-0">Belum punya akun?</p>
                            <a href="{{ route('register') }}" class="fw-bold text-primary text-decoration-none">Daftar Pelanggan Baru</a>
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- Copyright Bawah --}}
            <div class="text-center mt-3 text-muted small">
                &copy; {{ date('Y') }} Lhyna Collection. All rights reserved.
            </div>
        </div>
    </div>
</div>
@endsection