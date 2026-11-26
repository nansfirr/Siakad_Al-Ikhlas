@extends('layouts.app')
@section('title', 'Penilaian 6 Aspek')
@section('content')

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Pilih Kelas</label>
                <select name="id_kelas" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="semua" {{ $kelasId == 'semua' ? 'selected' : '' }}>-- Semua Kelas --</option>
                    @foreach($kelasSaya as $k)
                        <option value="{{ $k->id_kelas }}"
                            {{ $kelasId == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} ({{ $k->tahun_ajaran }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Semester</label>
                <select name="semester" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="1" {{ $semester == '1' ? 'selected' : '' }}>Semester 1</option>
                    <option value="2" {{ $semester == '2' ? 'selected' : '' }}>Semester 2</option>
                </select>
            </div>
        </form>
    </div>
</div>

{{-- Daftar Siswa --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0">Daftar Siswa — Semester {{ $semester }}</h6>
    </div>
    <div class="card-body">
        @if($siswa->isEmpty())
            <p class="text-muted text-center">Belum ada siswa di kelas ini.</p>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Status Penilaian (6 Aspek)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $i => $s)
                    @php
                        $nilaiSemester = $s->penilaian->where('semester', $semester);
                        $jumlahNilai   = $nilaiSemester->count();
                        $jumlahAspek   = $nilaiSemester->pluck('indikator.id_aspek')->filter()->unique()->count();
                        $targetAspek   = $totalAspek ?? 6;
                        $targetInd     = $totalIndikator ?? 24;
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="fw-semibold">{{ $s->nama_siswa }}</td>
                        <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                        <td>
                            @if($jumlahNilai >= $targetInd && $jumlahAspek >= $targetAspek)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Lengkap ({{ $jumlahAspek }}/{{ $targetAspek }} Aspek • {{ $jumlahNilai }}/{{ $targetInd }} Indikator)
                                </span>
                            @elseif($jumlahNilai > 0)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    Belum Lengkap ({{ $jumlahAspek }}/{{ $targetAspek }} Aspek • {{ $jumlahNilai }}/{{ $targetInd }} Indikator)
                                </span>
                            @else
                                <span class="badge bg-secondary">Belum Dinilai (0/{{ $targetAspek }} Aspek)</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('guru.penilaian.show', [$s->id_siswa, 'semester' => $semester]) }}"
                                class="btn {{ $jumlahNilai > 0 && $jumlahNilai < $targetInd ? 'btn-warning' : 'btn-success' }} btn-sm">
                                <i class="bi bi-pencil-square"></i>
                                {{ $jumlahNilai >= $targetInd ? 'Edit Penilaian' : ($jumlahNilai > 0 ? 'Lengkapi (' . ($targetAspek - $jumlahAspek) . ' Aspek Lagi)' : 'Input Penilaian') }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
