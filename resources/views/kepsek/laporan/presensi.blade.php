@extends('layouts.app')
@section('title', 'Laporan Presensi')
@section('content')

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Filter Kelas</label>
                <select name="id_kelas" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ $kelasId==$k->id_kelas?'selected':'' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold small">Semester</label>
                <select name="semester" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="1" {{ $semester=='1'?'selected':'' }}>Semester 1</option>
                    <option value="2" {{ $semester=='2'?'selected':'' }}>Semester 2</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" class="form-control form-control-sm"
                    value="{{ $tahunAjaran }}" onchange="this.form.submit()">
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold">
        Laporan Presensi Seluruh Siswa — Semester {{ $semester }}
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm text-center align-middle">
            <thead class="table-success">
                <tr>
                    <th>No</th>
                    <th class="text-start">Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Tanpa Ket.</th>
                    <th>Total Hari</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $i => $s)
                @php $p = $rekapPresensi[$s->id_siswa] ?? null; @endphp
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td class="text-start">{{ $s->nama_siswa }}</td>
                    <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                    <td><span class="badge bg-success">{{ $p?->hadir ?? 0 }}</span></td>
                    <td><span class="badge bg-warning text-dark">{{ $p?->izin ?? 0 }}</span></td>
                    <td><span class="badge bg-danger">{{ $p?->tanpa_keterangan ?? 0 }}</span></td>
                    <td>{{ ($p?->hadir ?? 0) + ($p?->izin ?? 0) + ($p?->tanpa_keterangan ?? 0) }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-muted">Belum ada data presensi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection