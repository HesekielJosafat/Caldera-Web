@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Lupa Password</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <p class="text-muted">Masukkan email Anda, kami akan mengirimkan link reset password</p>
                    
                    <form method="POST" action="{{ route('password.otp.send') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kirim Link Reset</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}">Kembali ke Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection