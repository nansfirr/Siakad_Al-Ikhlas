@extends('layouts.app')

@section('title', 'Laporan Perkembangan')

@section('content')

<div class="container-fluid px-0">

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold small mb-1">Kelas</label>
                    <select name="id_kelas" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}"
                                {{ $kelasId == $k->id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} ({{ $k->tahun_ajaran }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label fw-semibold small mb-1">Semester</label>
                    <select name="semester" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="1" {{ $semester == 1 ? 'selected' : '' }}>Semester 1</option>
                        <option value="2" {{ $semester == 2 ? 'selected' : '' }}>Semester 2</option>
                    </select>
                </div>

                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold small mb-1">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" class="form-control form-control-sm"
                        value="{{ $tahunAjaran }}" onchange="this.form.submit()">
                </div>

                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-success btn-sm w-100">
                        <i class="bi bi-search me-1"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0">
                <i class="bi bi-graph-up-arrow text-success me-2"></i>
                Laporan Perkembangan Seluruh Siswa — Semester {{ $semester }} ({{ $tahunAjaran }})
            </h6>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle mb-2">
                <thead class="table-success text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th class="text-start">Nama Siswa</th>
                        <th>Kelas</th>
                        @foreach($aspek as $a)
                            <th>{{ $a->nama_aspek }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $i => $s)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $s->nama_siswa }}</td>
                            <td class="text-center">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                            @foreach($aspek as $a)
                                @php
                                    $nilai = $rekapNilai[$s->id_siswa][$a->id_aspek] ?? '-';
                                @endphp
                                <td class="text-center">
                                    @if($nilai !== '-')
                                        <span class="badge {{ $nilai == 'BSB' ? 'bg-success' : ($nilai == 'BSH' ? 'bg-primary' : ($nilai == 'MB' ? 'bg-warning text-dark' : 'bg-danger')) }}">
                                            {{ $nilai }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($aspek) + 3 }}" class="text-center text-muted py-3">
                                Belum ada data.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <small class="text-muted d-block mt-2">
                <strong>Keterangan:</strong>
                <span class="badge bg-success ms-1">BSB</span> Berkembang Sangat Baik |
                <span class="badge bg-primary ms-1">BSH</span> Berkembang Sesuai Harapan |
                <span class="badge bg-warning text-dark ms-1">MB</span> Mulai Berkembang |
                <span class="badge bg-danger ms-1">BB</span> Belum Berkembang |
                <span class="text-muted ms-1">-</span> Belum diinput
            </small>
        </div>
    </div>

</div>

@endsection
