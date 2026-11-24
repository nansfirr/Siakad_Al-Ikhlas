@extends('layouts.guest')

@php
    use App\Models\PengaturanSekolah;
    $pengaturan = PengaturanSekolah::first();
@endphp

@section('content')

<div class="container-fluid vh-100">
    <div class="row h-100">

        <!-- Bagian Kiri -->
        <div class="col-lg-7 d-none d-lg-flex bg-success text-white justify-content-center align-items-center">

            <div class="text-center px-5">

                @if($pengaturan && $pengaturan->logo)
                    <img src="{{ asset('storage/'.$pengaturan->logo) }}"
                         width="120"
                         class="mb-4"
                         alt="Logo Sekolah">
                @else
                    <i class="bi bi-mortarboard-fill display-1 mb-4"></i>
                @endif

                <h1 class="fw-bold">
                    {{ $pengaturan->nama_sekolah ?? 'SIAKAD TK AL-IKHLAS' }}
                </h1>

                <h4 class="mb-4">
                    {{ $pengaturan->alamat ?? 'Taliwang' }}
                </h4>

                <p class="fs-5">
                    Sistem Informasi Akademik
                    Pengelolaan Penilaian Perkembangan Anak
                    Berbasis Web.
                </p>

            </div>

        </div>

        <!-- Bagian Login -->
        <div class="col-lg-5 d-flex justify-content-center align-items-center bg-light p-3">

            <div class="card shadow border-0 rounded-4 p-4 w-100" style="max-width:420px">

                <div class="text-center mb-4">

                    <div class="d-lg-none mb-2">
                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold">
                            <i class="bi bi-mortarboard-fill me-1"></i>
                            {{ $pengaturan->nama_sekolah ?? 'SIAKAD TK AL-IKHLAS' }}
                        </span>
                    </div>

                    <i class="bi bi-person-circle text-success" style="font-size:64px"></i>

                    <h3 class="fw-bold mt-2">
                        Login
                    </h3>

                    <p class="text-muted">
                        Masukkan akun Anda
                    </p>

                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            required
                            autofocus>

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required>

                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Login
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>

@endsection