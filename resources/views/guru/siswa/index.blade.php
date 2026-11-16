@extends('layouts.app')
@section('title', 'Biodata Siswa & Orang Tua')
@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
        <h6 class="fw-bold mb-0"><i class="bi bi-people me-2 text-success"></i>Biodata Siswa & Orang Tua (Raport)</h6>

        <div class="d-flex align-items-center gap-2">
            @if($kelasSaya->isNotEmpty())
            <form method="GET" class="d-flex align-items-center gap-2 mb-0">
                <label class="small text-muted mb-0">Kelas:</label>
                <select name="id_kelas" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                    <option value="semua" {{ $kelasId == 'semua' ? 'selected' : '' }}>-- Semua Kelas --</option>
                    @foreach($kelasSaya as $kelas)
                        <option value="{{ $kelas->id_kelas }}" {{ $kelasId == $kelas->id_kelas ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }} ({{ $kelas->tahun_ajaran }})
                        </option>
                    @endforeach
                </select>
            </form>
            @endif

            <a href="{{ route('guru.siswa.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Siswa
            </a>
        </div>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>NIS</th>
                    <th>Nama Siswa & TTL</th>
                    <th>Kelas</th>
                    <th>L/P</th>
                    <th>Ayah/Wali</th>
                    <th>Ibu/Wali</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        @if($s->foto)
                            <img src="{{ asset('storage/'.$s->foto) }}"
                                class="rounded-circle" width="40" height="40"
                                style="object-fit:cover">
                        @else
                            <div class="bg-secondary rounded-circle d-flex align-items-center
                                justify-content-center text-white" style="width:40px;height:40px">
                                <i class="bi bi-person"></i>
                            </div>
                        @endif
                    </td>
                    <td>{{ $s->nis }}</td>
                    <td>
                        <div class="fw-semibold">{{ $s->nama_siswa }}</div>
                        <small class="text-muted">
                            {{ $s->tempat_lahir ?? 'Taliwang' }}, {{ $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                            @if($s->anak_ke) • Anak ke-{{ $s->anak_ke }} @endif
                        </small>
                    </td>
                    <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $s->jenis_kelamin }}</td>
                    <td>
                        <div>{{ $s->nama_wali ?? '-' }}</div>
                        @if($s->pekerjaan_wali)
                            <small class="text-muted">{{ $s->pekerjaan_wali }}</small>
                        @endif
                    </td>
                    <td>
                        <div>{{ $s->nama_ibu ?? '-' }}</div>
                        @if($s->pekerjaan_ibu)
                            <small class="text-muted">{{ $s->pekerjaan_ibu }}</small>
                        @endif
                    </td>
                    <td><small>{{ $s->alamat ?? '-' }}</small></td>
                    <td>
                        <a href="{{ route('guru.siswa.edit', $s->id_siswa) }}"
                            class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square me-1"></i> Edit Biodata
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-4">Belum ada data siswa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
