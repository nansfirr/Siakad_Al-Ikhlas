@extends('layouts.app')
@section('title', 'Edit Siswa')
@section('content')
<div class="card border-0 shadow-sm" style="max-width:600px">
    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0">Edit Siswa</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.siswa.update', $siswa->id_siswa) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">NIS</label>
                    <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
                        value="{{ old('nis', $siswa->nis) }}">
                    @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Nama Siswa</label>
                    <input type="text" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror"
                        value="{{ old('nama_siswa', $siswa->nama_siswa) }}">
                    @error('nama_siswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control"
                        value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kelas</label>
                    <select name="id_kelas" class="form-select">
                        @foreach($kelas as $k)
                            <option value="{{ $k->id_kelas }}"
                                {{ old('id_kelas', $siswa->id_kelas) == $k->id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} ({{ $k->tahun_ajaran }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Nama Wali</label>
                    <input type="text" name="nama_wali" class="form-control"
                        value="{{ old('nama_wali', $siswa->nama_wali) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Foto</label>
                    @if($siswa->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$siswa->foto) }}" height="80"
                                class="rounded" style="object-fit:cover">
                            <small class="text-muted d-block">Foto saat ini</small>
                        </div>
                    @endif
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning">Update</button>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection