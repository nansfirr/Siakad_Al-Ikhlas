@extends('layouts.app')
@section('title', 'Edit Kelas')
@section('content')
<div class="card border-0 shadow-sm" style="max-width:600px">
    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0">Edit Kelas</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.kelas.update', $kelas->id_kelas) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror"
                    value="{{ old('nama_kelas', $kelas->nama_kelas) }}">
                @error('nama_kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror"
                    value="{{ old('tahun_ajaran', $kelas->tahun_ajaran) }}">
                @error('tahun_ajaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Wali Kelas <span class="text-muted small">(opsional)</span></label>
                <select name="id_user" class="form-select @error('id_user') is-invalid @enderror">
                    <option value="">-- Belum Ditentukan / Guru Umum --</option>
                    @foreach($guru as $g)
                        <option value="{{ $g->id }}"
                            {{ old('id_user', $kelas->id_user) == $g->id ? 'selected' : '' }}>
                            {{ $g->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_user')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">Update</button>
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection