@extends('layouts.app')

@section('title', 'Input Presensi')

@section('content')

<style>
    /* Tombol pilihan status presensi ramah sentuhan HP */
    .presensi-btn-group {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
    }

    .presensi-btn-group .btn {
        font-size: 0.78rem;
        font-weight: 600;
        padding: 6px 4px;
        border-radius: 8px;
    }

    /* Tampilan kartu di layar HP (< 768px) agar guru mudah mengabsen tanpa geser tabel */
    @media (max-width: 767.98px) {
        .table-presensi thead {
            display: none;
        }

        .table-presensi,
        .table-presensi tbody,
        .table-presensi tr,
        .table-presensi td {
            display: block;
            width: 100%;
        }

        .table-presensi tr {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 12px;
            padding: 12px;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }

        .table-presensi td {
            border: none;
            padding: 4px 0;
            text-align: left !important;
        }

        .table-presensi td.col-no {
            display: none;
        }

        .presensi-btn-group .btn {
            padding: 8px 4px;
            font-size: 0.82rem;
        }
    }
</style>

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">

        <form method="GET"
              action="{{ route('guru.presensi.index') }}"
              class="row g-2 align-items-end">

            <div class="col-12 col-md-3">
                <label class="form-label fw-semibold small mb-1">
                    Pilih Kelas
                </label>

                <select name="id_kelas"
                        class="form-select form-select-sm"
                        onchange="this.form.submit()">

                    <option value="semua" {{ $kelasId == 'semua' ? 'selected' : '' }}>
                        -- Semua Kelas --
                    </option>

                    @foreach($kelasSaya as $k)
                        <option value="{{ $k->id_kelas }}"
                            {{ $kelasId == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} ({{ $k->tahun_ajaran }})
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-6 col-md-2">
                <label class="form-label fw-semibold small mb-1">
                    Semester
                </label>

                <select name="semester"
                        class="form-select form-select-sm"
                        onchange="this.form.submit()">

                    <option value="1" {{ $semester == '1' ? 'selected' : '' }}>
                        Semester 1
                    </option>

                    <option value="2" {{ $semester == '2' ? 'selected' : '' }}>
                        Semester 2
                    </option>

                </select>
            </div>

            <div class="col-6 col-md-3">
                <label class="form-label fw-semibold small mb-1">
                    Tahun Ajaran
                </label>

                <input
                    type="text"
                    name="tahun_ajaran"
                    class="form-control form-control-sm"
                    value="{{ $tahunAjaran }}"
                    onchange="this.form.submit()">
            </div>

            <div class="col-12 col-md-3">
                <label class="form-label fw-semibold small mb-1">
                    Tanggal Presensi
                </label>

                <input
                    type="date"
                    name="tanggal"
                    class="form-control form-control-sm"
                    value="{{ $tanggal }}"
                    onchange="this.form.submit()">
            </div>

        </form>

    </div>
</div>


{{-- Form Presensi --}}
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">

        <div>
            <h6 class="fw-bold mb-0">
                Daftar Presensi — {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
            </h6>
            <small class="text-muted">Ketuk status kehadiran untuk masing-masing siswa</small>
        </div>

        <div class="d-flex align-items-center gap-2">
            @if($siswa->isNotEmpty())
                <button type="button" class="btn btn-outline-success btn-sm" onclick="setSemuaHadir()">
                    <i class="bi bi-check2-all"></i> Set Semua Hadir
                </button>
            @endif
            <span class="badge bg-success">
                {{ $siswa->count() }} Siswa
            </span>
        </div>

    </div>

    <div class="card-body">

        @if($siswa->isEmpty())

            <p class="text-center text-muted py-3 mb-0">
                Belum ada siswa pada kelas ini.
            </p>

        @else

        <form action="{{ route('guru.presensi.store') }}" method="POST">

            @csrf

            <input type="hidden" name="id_kelas" value="{{ $kelasId }}">
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">

            <table class="table table-hover align-middle table-presensi mb-3">

                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="28%">Nama Siswa</th>
                        <th width="42%" class="text-center">Status Kehadiran</th>
                        <th width="25%">Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($siswa as $i => $s)
                    @php
                        $existing = $presensiHariIni[$s->id_siswa] ?? null;
                        $currentStatus = $existing?->status ?? 'hadir';
                    @endphp

                    <tr>
                        <td class="col-no">{{ $i + 1 }}</td>

                        <td>
                            <div class="fw-bold text-dark">
                                <span class="d-inline d-md-none text-success me-1">{{ $i + 1 }}.</span>
                                {{ $s->nama_siswa }}
                            </div>
                            <small class="text-muted">
                                NIS: {{ $s->nis }}
                                @if($s->kelas) • {{ $s->kelas->nama_kelas }} @endif
                            </small>
                        </td>

                        <td>
                            <div class="presensi-btn-group">
                                <input type="radio" class="btn-check radio-hadir"
                                       name="presensi[{{ $s->id_siswa }}][status]"
                                       id="status_hadir_{{ $s->id_siswa }}"
                                       value="hadir"
                                       {{ $currentStatus === 'hadir' ? 'checked' : '' }} required>
                                <label class="btn btn-outline-success" for="status_hadir_{{ $s->id_siswa }}">
                                    Hadir
                                </label>

                                <input type="radio" class="btn-check"
                                       name="presensi[{{ $s->id_siswa }}][status]"
                                       id="status_sakit_{{ $s->id_siswa }}"
                                       value="sakit"
                                       {{ $currentStatus === 'sakit' ? 'checked' : '' }}>
                                <label class="btn btn-outline-info" for="status_sakit_{{ $s->id_siswa }}">
                                    Sakit
                                </label>

                                <input type="radio" class="btn-check"
                                       name="presensi[{{ $s->id_siswa }}][status]"
                                       id="status_izin_{{ $s->id_siswa }}"
                                       value="izin"
                                       {{ $currentStatus === 'izin' ? 'checked' : '' }}>
                                <label class="btn btn-outline-warning" for="status_izin_{{ $s->id_siswa }}">
                                    Izin
                                </label>

                                <input type="radio" class="btn-check"
                                       name="presensi[{{ $s->id_siswa }}][status]"
                                       id="status_alpha_{{ $s->id_siswa }}"
                                       value="tanpa_keterangan"
                                       {{ $currentStatus === 'tanpa_keterangan' ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger" for="status_alpha_{{ $s->id_siswa }}">
                                    Alpha
                                </label>
                            </div>
                        </td>

                        <td>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                name="presensi[{{ $s->id_siswa }}][keterangan]"
                                value="{{ $existing?->keterangan }}"
                                placeholder="Catatan / keterangan (opsional)">
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

            <button type="submit" class="btn btn-success w-100 w-md-auto py-2 px-4 fw-semibold">
                <i class="bi bi-save me-1"></i>
                Simpan Presensi
            </button>

        </form>

        @endif

    </div>

</div>

<script>
    function setSemuaHadir() {
        document.querySelectorAll('.radio-hadir').forEach((radio) => {
            radio.checked = true;
        });
    }
</script>

@endsection
