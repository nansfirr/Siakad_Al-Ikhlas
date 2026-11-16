@extends('layouts.app')
@section('title', 'Penilaian Kegiatan Tambahan')
@section('content')

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

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0">Daftar Siswa — Penilaian Kegiatan Tambahan</h6>
    </div>
    <div class="card-body">
        @if($siswa->isEmpty())
            <p class="text-muted text-center">Belum ada siswa di kelas ini.</p>
        @else
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $i => $s)
                @php
                    $jumlahNilai = $s->nilaiKegiatan->where('semester', $semester)->count();
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->nama_siswa }}</td>
                    <td>
                        @if($jumlahNilai > 0)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle"></i> Sudah ({{ $jumlahNilai }} item)
                            </span>
                        @else
                            <span class="badge bg-secondary">Belum Dinilai</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('guru.kegiatan.show', [$s->id_siswa, 'semester' => $semester]) }}"
                            class="btn btn-success btn-sm">
                            <i class="bi bi-pencil-square"></i>
                            {{ $jumlahNilai > 0 ? 'Edit' : 'Input' }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection