@extends('layouts.app')
@section('title', 'Tambah Kelas')
@section('content')
<div class="card border-0 shadow-sm" style="max-width:600px">
    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0">Tambah Kelas</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.kelas.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror"
                    value="{{ old('nama_kelas') }}" placeholder="contoh: Kelompok A">
                @error('nama_kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror"
                    value="{{ old('tahun_ajaran') }}" placeholder="contoh: 2025/2026">
                @error('tahun_ajaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Wali Kelas</label>
                <select name="id_user" class="form-select @error('id_user') is-invalid @enderror">
                    <option value="">-- Pilih Guru --</option>
                    @foreach($guru as $g)
                        <option value="{{ $g->id }}" {{ old('id_user') == $g->id ? 'selected' : '' }}>
                            {{ $g->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_user')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection