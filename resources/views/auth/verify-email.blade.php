@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent text-center pt-4">
                    <h4 class="fw-bold mb-2">Verifikasi Alamat Email</h4>
                </div>
                <div class="card-body p-4 text-center">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <i class="fas fa-envelope fa-4x text-primary mb-3"></i>
                        <p>Terima kasih telah mendaftar! Silakan verifikasi alamat email Anda dengan mengklik link yang telah kami kirimkan.</p>
                        <p>Jika Anda tidak menerima email, klik tombol di bawah untuk mengirim ulang.</p>
                    </div>

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection