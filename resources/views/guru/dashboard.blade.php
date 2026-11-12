@extends('layouts.app')
@section('title', 'Dashboard Guru')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1">
            <i class="bi bi-mortarboard-fill text-success"></i>
            Dashboard Guru
        </h3>
        <p class="text-muted mb-0">
            Selamat datang,
            <strong>{{ Auth::user()->name }}</strong>.
            Semoga aktivitas mengajar hari ini berjalan lancar.
        </p>
    </div>

    {{-- Statistik --}}
    <div class="row g-3 mb-4">

        <div class="col-md-6">
            <div class="card border-0 shadow-sm text-white bg-success">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-2 fw-bold">
                            {{ $kelas->count() }}
                        </div>
                        <div>Kelas Saya</div>
                    </div>

                    <i class="bi bi-door-open fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm text-white bg-primary">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-2 fw-bold">
                            {{ $total_siswa }}
                        </div>
                        <div>Total Siswa</div>
                    </div>

                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        {{-- Daftar kelas --}}
        <div class="col-lg-7 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-journal-text me-2"></i>
                        Daftar Kelas Saya
                    </h5>
                </div>

                <div class="card-body">

                    @forelse($kelas as $k)

                        <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                            <div>

                                <h6 class="mb-1 fw-bold">
                                    {{ $k->nama_kelas }}
                                </h6>

                                <small class="text-muted">
                                    Tahun Ajaran {{ $k->tahun_ajaran }}
                                </small>

                            </div>

                            <span class="badge bg-success rounded-pill px-3 py-2">
                                {{ $k->siswa->count() }} Siswa
                            </span>

                        </div>

                    @empty

                        <div class="text-center py-4">

                            <i class="bi bi-folder-x fs-1 text-secondary"></i>

                            <p class="text-muted mt-2 mb-0">
                                Belum ada kelas yang ditugaskan.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

        {{-- Informasi --}}
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Informasi Sistem
                    </h5>
                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>
                            <td>Tahun Ajaran</td>
                            <td class="fw-semibold">2025/2026</td>
                        </tr>

                        <tr>
                            <td>Semester</td>
                            <td class="fw-semibold">1</td>
                        </tr>

                        <tr>
                            <td>Total Kelas</td>
                            <td class="fw-semibold">
                                {{ $kelas->count() }}
                            </td>
                        </tr>

                        <tr>
                            <td>Total Siswa</td>
                            <td class="fw-semibold">
                                {{ $total_siswa }}
                            </td>
                        </tr>

                    </table>

                    <hr>

                    <h6 class="fw-bold">
                        Aktivitas Guru
                    </h6>

                    <ul class="mb-0">

                        <li>Input Penilaian</li>

                        <li>Input Presensi</li>

                        <li>Cetak Rapor</li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection