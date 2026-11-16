@extends('layouts.app')
@section('title', 'Input Antropometri')
@section('content')

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Pilih Kelas</label>
                <select name="id_kelas" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="semua" {{ $kelasId == 'semua' ? 'selected' : '' }}>-- Semua Kelas --</option>
                    @foreach($kelasSaya as $k)
                        <option value="{{ $k->id_kelas }}"
                            {{ $kelasId == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
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
                    value="{{ $tahunAjaran }}" placeholder="2025/2026" onchange="this.form.submit()">
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0">Data Antropometri Siswa</h6>
    </div>
    <div class="card-body">
        @if($siswa->isEmpty())
            <p class="text-muted text-center">Belum ada siswa di kelas ini.</p>
        @else
        <form action="{{ route('guru.antropometri.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_kelas" value="{{ $kelasId }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Tinggi Badan (cm)</th>
                            <th>Berat Badan (kg)</th>
                            <th>Lingkar Kepala (cm)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $i => $s)
                        @php $ant = $antropometriData[$s->id_siswa] ?? null; @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $s->nama_siswa }}</td>
                            <td>
                                <input type="number" step="0.1"
                                    name="antropometri[{{ $s->id_siswa }}][tinggi_badan]"
                                    class="form-control form-control-sm"
                                    value="{{ $ant?->tinggi_badan }}"
                                    style="width:100px">
                            </td>
                            <td>
                                <input type="number" step="0.1"
                                    name="antropometri[{{ $s->id_siswa }}][berat_badan]"
                                    class="form-control form-control-sm"
                                    value="{{ $ant?->berat_badan }}"
                                    style="width:100px">
                            </td>
                            <td>
                                <input type="number" step="0.1"
                                    name="antropometri[{{ $s->id_siswa }}][lingkar_kepala]"
                                    class="form-control form-control-sm"
                                    value="{{ $ant?->lingkar_kepala }}"
                                    style="width:100px">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-success mt-2">
                <i class="bi bi-save"></i> Simpan Antropometri
            </button>
        </form>
        @endif
    </div>
</div>
@endsection