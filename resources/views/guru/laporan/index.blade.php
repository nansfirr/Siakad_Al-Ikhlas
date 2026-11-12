@extends('layouts.app')
@section('title', 'Laporan Rekapitulasi')
@section('content')

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Pilih Kelas</label>
                <select name="id_kelas" class="form-select form-select-sm" onchange="this.form.submit()">
                    @foreach($kelasSaya as $k)
                        <option value="{{ $k->id_kelas }}"
                            {{ $kelasId == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} ({{ $k->tahun_ajaran }})
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
            <div class="col-md-2">
                <a href="{{ route('guru.laporan.exportPdf', ['id_kelas'=>$kelasId,'semester'=>$semester,'tahun_ajaran'=>$tahunAjaran]) }}"
                    class="btn btn-danger btn-sm w-100">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Rekap --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0">
            Rekapitulasi Penilaian — {{ $kelas->nama_kelas ?? '-' }}
            | Semester {{ $semester }} | TA {{ $tahunAjaran }}
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center">
                <thead class="table-success">
                    <tr>
                        <th rowspan="2" class="align-middle">No</th>
                        <th rowspan="2" class="align-middle text-start">Nama Siswa</th>
                        @foreach($aspek as $a)
                        <th colspan="1">{{ $a->nama_aspek }}</th>
                        @endforeach
                        <th colspan="3">Presensi</th>
                    </tr>
                    <tr>
                        @foreach($aspek as $a)
                        <th class="small">Nilai</th>
                        @endforeach
                        <th class="small">H</th>
                        <th class="small">I</th>
                        <th class="small">TK</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $i => $s)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td class="text-start">{{ $s->nama_siswa }}</td>
                        @foreach($aspek as $a)
                        @php $nilai = $rekapNilai[$s->id_siswa][$a->id_aspek] ?? '-'; @endphp
                        <td>
                            <span class="badge
                                {{ $nilai=='BSB' ? 'bg-success' :
                                   ($nilai=='BSH' ? 'bg-primary' :
                                   ($nilai=='MB'  ? 'bg-warning text-dark' :
                                   ($nilai=='BB'  ? 'bg-danger' : 'bg-secondary'))) }}">
                                {{ $nilai }}
                            </span>
                        </td>
                        @endforeach
                        @php $p = $rekapPresensi[$s->id_siswa] ?? null; @endphp
                        <td>{{ $p?->hadir ?? '-' }}</td>
                        <td>{{ $p?->izin ?? '-' }}</td>
                        <td>{{ $p?->tanpa_keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $aspek->count() + 5 }}" class="text-muted">
                            Belum ada data.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <small class="text-muted">
            H = Hadir | I = Izin | TK = Tanpa Keterangan |
            BSB = Berkembang Sangat Baik | BSH = Berkembang Sesuai Harapan |
            MB = Mulai Berkembang | BB = Belum Berkembang
        </small>
    </div>
</div>
@endsection