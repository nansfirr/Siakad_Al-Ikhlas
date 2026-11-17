@extends('layouts.app')
@section('title', 'Laporan Presensi')
@section('content')

{{-- Filter Bar --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('kepsek.laporan.presensi') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Filter Kelas</label>
                <select name="id_kelas" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ $kelasId == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} ({{ $k->tahun_ajaran }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold small">Semester</label>
                <select name="semester" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="1" {{ $semester == '1' ? 'selected' : '' }}>Semester 1</option>
                    <option value="2" {{ $semester == '2' ? 'selected' : '' }}>Semester 2</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" class="form-control form-control-sm"
                    value="{{ $tahunAjaran }}" onchange="this.form.submit()">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Pilih Tanggal (Cek Harian)</label>
                <div class="d-flex gap-2">
                    <input type="date" name="tanggal" class="form-control form-control-sm"
                        value="{{ $tanggal }}" onchange="this.form.submit()">
                    <a href="{{ route('kepsek.laporan.presensi', ['id_kelas' => $kelasId, 'semester' => $semester, 'tahun_ajaran' => $tahunAjaran, 'tanggal' => date('Y-m-d')]) }}"
                       class="btn btn-outline-success btn-sm text-nowrap">
                        Hari Ini
                    </a>
                </div>
            </div>
        </form>

        @if($tanggalTersedia->isNotEmpty())
            <div class="mt-3 pt-2 border-top d-flex flex-wrap align-items-center gap-1">
                <small class="text-muted me-2"><i class="bi bi-calendar-event me-1"></i>Tanggal Terinput:</small>
                @foreach($tanggalTersedia as $tglItem)
                    <a href="{{ route('kepsek.laporan.presensi', ['id_kelas' => $kelasId, 'semester' => $semester, 'tahun_ajaran' => $tahunAjaran, 'tanggal' => $tglItem]) }}"
                       class="badge text-decoration-none {{ $tanggal == $tglItem ? 'bg-success' : 'bg-light text-dark border' }}">
                        {{ \Carbon\Carbon::parse($tglItem)->translatedFormat('d M Y') }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- ========================================================= --}}
{{-- BAGIAN 1: LAPORAN PRESENSI HARIAN (SIAPA YANG MASUK & TIDAK) --}}
{{-- ========================================================= --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
        <div>
            <h6 class="fw-bold mb-0">
                <i class="bi bi-calendar-check text-success me-2"></i>
                Presensi Harian — {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
            </h6>
            <small class="text-muted">Daftar kehadiran siswa pada tanggal yang dipilih</small>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <span class="badge bg-success px-3 py-2">
                Hadir (Masuk): {{ $ringkasanHarian['hadir'] }}
            </span>
            <span class="badge bg-info text-dark px-3 py-2">
                Sakit: {{ $ringkasanHarian['sakit'] }}
            </span>
            <span class="badge bg-warning text-dark px-3 py-2">
                Izin: {{ $ringkasanHarian['izin'] }}
            </span>
            <span class="badge bg-danger px-3 py-2">
                Tanpa Ket.: {{ $ringkasanHarian['tanpa_keterangan'] }}
            </span>
            @if($ringkasanHarian['belum_diinput'] > 0)
                <span class="badge bg-secondary px-3 py-2">
                    Belum Diabsen: {{ $ringkasanHarian['belum_diinput'] }}
                </span>
            @endif
        </div>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
            <thead class="table-success">
                <tr>
                    <th width="5%">No</th>
                    <th width="12%">NIS</th>
                    <th class="text-start">Nama Siswa</th>
                    <th width="15%">Kelas</th>
                    <th width="20%">Status Kehadiran</th>
                    <th class="text-start" width="22%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $i => $s)
                    @php
                        $absen = $presensiHarian[$s->id_siswa] ?? null;
                        $status = $absen?->status;
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $s->nis }}</td>
                        <td class="text-start fw-semibold">{{ $s->nama_siswa }}</td>
                        <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                        <td>
                            @if($status === 'hadir')
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Hadir (Masuk)</span>
                            @elseif($status === 'sakit')
                                <span class="badge bg-info text-dark"><i class="bi bi-Thermometer-half me-1"></i>Tidak Masuk (Sakit)</span>
                            @elseif($status === 'izin')
                                <span class="badge bg-warning text-dark"><i class="bi bi-envelope me-1"></i>Tidak Masuk (Izin)</span>
                            @elseif($status === 'tanpa_keterangan')
                                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Tidak Masuk (Tanpa Ket.)</span>
                            @else
                                <span class="badge bg-secondary">Belum Diinput</span>
                            @endif
                        </td>
                        <td class="text-start text-muted small">
                            {{ $absen?->keterangan ?: '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted py-3">Belum ada data siswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ========================================================= --}}
{{-- BAGIAN 2: REKAPITULASI TOTAL PRESENSI SEMESTER --}}
{{-- ========================================================= --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-bar-chart-steps text-primary me-2"></i>
            Rekapitulasi Total Presensi Siswa — Semester {{ $semester }} ({{ $tahunAjaran }})
        </h6>
        <small class="text-muted">Akumulasi total kehadiran seluruh siswa selama satu semester</small>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
            <thead class="table-success">
                <tr>
                    <th width="5%">No</th>
                    <th width="12%">NIS</th>
                    <th class="text-start">Nama Siswa</th>
                    <th width="15%">Kelas</th>
                    <th width="10%">Hadir</th>
                    <th width="10%">Sakit</th>
                    <th width="10%">Izin</th>
                    <th width="12%">Tanpa Ket.</th>
                    <th width="12%">Total Hari</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $i => $s)
                @php
                    $p = $rekapPresensi[$s->id_siswa] ?? null;
                    $jmlHadir = $p?->hadir ?? 0;
                    $jmlSakit = $p?->sakit ?? 0;
                    $jmlIzin  = $p?->izin ?? 0;
                    $jmlAlpha = $p?->tanpa_keterangan ?? 0;
                    $totalHari = $jmlHadir + $jmlSakit + $jmlIzin + $jmlAlpha;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->nis }}</td>
                    <td class="text-start fw-semibold">{{ $s->nama_siswa }}</td>
                    <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                    <td><span class="badge bg-success">{{ $jmlHadir }}</span></td>
                    <td><span class="badge bg-info text-dark">{{ $jmlSakit }}</span></td>
                    <td><span class="badge bg-warning text-dark">{{ $jmlIzin }}</span></td>
                    <td><span class="badge bg-danger">{{ $jmlAlpha }}</span></td>
                    <td class="fw-bold">{{ $totalHari }}</td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-muted py-3">Belum ada data presensi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
