@extends('layouts.app')
@section('title','Dashboard Kepala Sekolah')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1">
            <i class="bi bi-person-workspace text-primary"></i>
            Dashboard Kepala Sekolah
        </h3>

        <p class="text-muted mb-0">
            Selamat datang,
            <strong>{{ Auth::user()->name }}</strong>.
            Berikut ringkasan data akademik TK Al-Ikhlas.
        </p>
    </div>

    {{-- Statistik --}}
    <div class="row g-3 mb-4">

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <h2 class="fw-bold mb-0">
                            {{ $data['total_siswa'] }}
                        </h2>
                        <small>Total Siswa</small>
                    </div>

                    <i class="bi bi-people-fill fs-1 opacity-50"></i>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <h2 class="fw-bold mb-0">
                            {{ $data['total_kelas'] }}
                        </h2>
                        <small>Total Kelas</small>
                    </div>

                    <i class="bi bi-door-open-fill fs-1 opacity-50"></i>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-warning text-dark">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <h2 class="fw-bold mb-0">
                            {{ $data['total_guru'] }}
                        </h2>
                        <small>Total Guru</small>
                    </div>

                    <i class="bi bi-person-badge-fill fs-1 opacity-50"></i>

                </div>
            </div>
        </div>

    </div>

    <div class="row">

        {{-- Distribusi Nilai --}}
        <div class="col-lg-8 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-bar-chart-line me-2"></i>
                        Distribusi Nilai Per Aspek
                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover text-center align-middle">

                            <thead class="table-success">

                            <tr>

                                <th class="text-start">
                                    Aspek Perkembangan
                                </th>

                                <th>BB</th>
                                <th>MB</th>
                                <th>BSH</th>
                                <th>BSB</th>

                            </tr>

                            </thead>

                            <tbody>

                            @foreach($aspek as $a)

                            <tr>

                                <td class="text-start fw-semibold">
                                    {{ $a->nama_aspek }}
                                </td>

                                @foreach(['BB','MB','BSH','BSB'] as $n)

                                <td>

                                    <span class="badge
                                        {{ $n=='BSB' ? 'bg-success'
                                        : ($n=='BSH' ? 'bg-primary'
                                        : ($n=='MB' ? 'bg-warning text-dark'
                                        : 'bg-danger')) }}">

                                        {{ $grafik[$a->nama_aspek][$n] ?? 0 }}

                                    </span>

                                </td>

                                @endforeach

                            </tr>

                            @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        {{-- Informasi --}}
        <div class="col-lg-4 mb-4">

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
                            <td>Total Siswa</td>
                            <td class="fw-bold">{{ $data['total_siswa'] }}</td>
                        </tr>

                        <tr>
                            <td>Total Guru</td>
                            <td class="fw-bold">{{ $data['total_guru'] }}</td>
                        </tr>

                        <tr>
                            <td>Total Kelas</td>
                            <td class="fw-bold">{{ $data['total_kelas'] }}</td>
                        </tr>

                        <tr>
                            <td>Jumlah Aspek</td>
                            <td class="fw-bold">{{ $aspek->count() }}</td>
                        </tr>

                    </table>

                    <hr>

                    <div class="small text-muted">

                        Kepala sekolah dapat memonitor perkembangan peserta didik,
                        melihat laporan perkembangan, serta memantau presensi siswa
                        melalui menu yang tersedia.

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Daftar Kelas --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <h5 class="fw-bold mb-0">

                <i class="bi bi-building me-2"></i>

                Daftar Kelas

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                    <tr>

                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Wali Kelas</th>
                        <th class="text-center">Jumlah Siswa</th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($kelasList as $i=>$k)

                    <tr>

                        <td>{{ $i+1 }}</td>

                        <td>{{ $k->nama_kelas }}</td>

                        <td>{{ $k->tahun_ajaran }}</td>

                        <td>{{ $k->user->name ?? '-' }}</td>

                        <td class="text-center">

                            <span class="badge bg-success rounded-pill px-3">

                                {{ $k->siswa->count() }}

                            </span>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="text-center text-muted py-4">

                            Belum ada data kelas.

                        </td>

                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection