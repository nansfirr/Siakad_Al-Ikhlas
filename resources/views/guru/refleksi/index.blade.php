@extends('layouts.app')
@section('title', 'Refleksi Guru')
@section('content')

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Pilih Kelas</label>
                <select name="id_kelas" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="semua" {{ $kelasId == 'semua' ? 'selected' : '' }}>-- Semua Kelas --</option>
                    @foreach($kelasSaya as $k)
                        <option value="{{ $k->id_kelas }}" {{ $kelasId == $k->id_kelas ? 'selected' : '' }}>
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
                       value="{{ $tahunAjaran }}" onchange="this.form.submit()">
            </div>
        </form>
    </div>
</div>

<form action="{{ route('guru.refleksi.store') }}" method="POST">
    @csrf
    <input type="hidden" name="id_kelas" value="{{ $kelasId }}">
    <input type="hidden" name="semester" value="{{ $semester }}">
    <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">

    @forelse($siswa as $i => $s)
        @php $ref = $refleksiData[$s->id_siswa] ?? null; @endphp
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <label class="form-label fw-bold text-success">
                    {{ $i + 1 }}. {{ $s->nama_siswa }} 
                    <span class="text-muted fw-normal">| NIS: {{ $s->nis }}</span>
                </label>
                <textarea name="refleksi[{{ $s->id_siswa }}][catatan_guru]" 
                          class="form-control" rows="3"
                          placeholder="Tuliskan catatan perkembangan dan refleksi untuk {{ $s->nama_siswa }}...">{{ old('refleksi.'.$s->id_siswa.'.catatan_guru', $ref?->catatan_guru) }}</textarea>
            </div>
        </div>
    @empty
        <p class="text-muted text-center">Belum ada siswa di kelas ini.</p>
    @endforelse

    @if($siswa->isNotEmpty())
        <button type="submit" class="btn btn-success mb-4">
            <i class="bi bi-save"></i> Simpan Semua Refleksi
        </button>
    @endif
</form>
@endsection