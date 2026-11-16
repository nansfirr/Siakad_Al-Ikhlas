@extends('layouts.app')

@section('title', 'Input Presensi')

@section('content')

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">

        <form method="GET"
              action="{{ route('guru.presensi.index') }}"
              class="row g-2 align-items-end">

            <div class="col-md-3">
                <label class="form-label fw-semibold small">
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
                            {{ $kelasId==$k->id_kelas ? 'selected' : '' }}>

                            {{ $k->nama_kelas }}
                            ({{ $k->tahun_ajaran }})

                        </option>

                    @endforeach

                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold small">
                    Semester
                </label>

                <select name="semester"
                        class="form-select form-select-sm"
                        onchange="this.form.submit()">

                    <option value="1"
                        {{ $semester=='1' ? 'selected':'' }}>
                        Semester 1
                    </option>

                    <option value="2"
                        {{ $semester=='2' ? 'selected':'' }}>
                        Semester 2
                    </option>

                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold small">
                    Tahun Ajaran
                </label>

                <input
                    type="text"
                    name="tahun_ajaran"
                    class="form-control form-control-sm"
                    value="{{ $tahunAjaran }}"
                    onchange="this.form.submit()">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold small">
                    Tanggal
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

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h6 class="fw-bold mb-0">
            Daftar Presensi —
            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
        </h6>

        <span class="badge bg-success">
            {{ $siswa->count() }} Siswa
        </span>

    </div>

    <div class="card-body">

        @if($siswa->isEmpty())

            <p class="text-center text-muted">
                Belum ada siswa pada kelas ini.
            </p>

        @else

        <form action="{{ route('guru.presensi.store') }}"
              method="POST">

            @csrf

            <input type="hidden"
                   name="id_kelas"
                   value="{{ $kelasId }}">

            <input type="hidden"
                   name="tanggal"
                   value="{{ $tanggal }}">

            <input type="hidden"
                   name="semester"
                   value="{{ $semester }}">

            <input type="hidden"
                   name="tahun_ajaran"
                   value="{{ $tahunAjaran }}">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>No</th>

                            <th>Nama Siswa</th>

                            <th class="text-center">
                                Hadir
                            </th>

                            <th class="text-center">
                                Sakit
                            </th>

                            <th class="text-center">
                                Izin
                            </th>

                            <th class="text-center">
                                Tanpa Ket.
                            </th>

                            <th>Keterangan</th>

                        </tr>

                    </thead>

                    <tbody>

                    @foreach($siswa as $i => $s)

                        @php
                            $existing = $presensiHariIni[$s->id_siswa] ?? null;
                        @endphp

                        <tr>

                            <td>{{ $i+1 }}</td>

                            <td>{{ $s->nama_siswa }}</td>

                            @foreach(['hadir','sakit','izin','tanpa_keterangan'] as $status)

                            <td class="text-center">

                                <div class="form-check d-flex justify-content-center">

                                    <input
                                        type="radio"
                                        class="form-check-input"

                                        name="presensi[{{ $s->id_siswa }}][status]"

                                        value="{{ $status }}"

                                        {{ ($existing?->status ?? 'hadir') == $status ? 'checked' : '' }}

                                        required>

                                </div>

                            </td>

                            @endforeach

                            <td>

                                <input
                                    type="text"

                                    class="form-control form-control-sm"

                                    name="presensi[{{ $s->id_siswa }}][keterangan]"

                                    value="{{ $existing?->keterangan }}"

                                    placeholder="Opsional">

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

            <button class="btn btn-success">

                <i class="bi bi-save"></i>

                Simpan Presensi

            </button>

        </form>

        @endif

    </div>

</div>

@endsection