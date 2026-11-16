@extends('layouts.app')
@section('title', 'Tambah Siswa')
@section('content')
<div class="card border-0 shadow-sm" style="max-width:850px">
    <div class="card-header bg-white py-3">
        <h6 class="fw-bold mb-0"><i class="bi bi-person-plus me-2 text-success"></i>Tambah Data Siswa & Orang Tua</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h6 class="fw-bold text-success border-bottom pb-2 mb-3">A. Data Pribadi Siswa</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">NIS <span class="text-danger">*</span></label>
                    <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
                        value="{{ old('nis') }}" placeholder="Nomor Induk Siswa">
                    @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kelas / Kelompok <span class="text-danger">*</span></label>
                    <select name="id_kelas" class="form-select @error('id_kelas') is-invalid @enderror">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} ({{ $k->tahun_ajaran }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Nama Lengkap Anak/Siswa <span class="text-danger">*</span></label>
                    <input type="text" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror"
                        value="{{ old('nama_siswa') }}" placeholder="Masukkan nama lengkap siswa sesuai akta kelahiran">
                    @error('nama_siswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
                        value="{{ old('tempat_lahir', 'Taliwang') }}" placeholder="Contoh: Taliwang">
                    @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir') }}">
                    @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Anak Ke-</label>
                    <input type="text" name="anak_ke" class="form-control @error('anak_ke') is-invalid @enderror"
                        value="{{ old('anak_ke') }}" placeholder="Contoh: 1 / Pertama">
                    @error('anak_ke')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Agama</label>
                    <select name="agama" class="form-select @error('agama') is-invalid @enderror">
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agm)
                            <option value="{{ $agm }}" {{ old('agama', 'Islam') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                        @endforeach
                    </select>
                    @error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kewarganegaraan</label>
                    <input type="text" name="kewarganegaraan" class="form-control @error('kewarganegaraan') is-invalid @enderror"
                        value="{{ old('kewarganegaraan', 'Indonesia') }}">
                    @error('kewarganegaraan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Alamat tempat tinggal siswa">{{ old('alamat') }}</textarea>
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Foto Siswa <span class="text-muted small">(opsional, ditampilkan di halaman biodata raport)</span></label>
                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                        accept="image/*">
                    @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <h6 class="fw-bold text-success border-bottom pb-2 mb-3">B. Data Orang Tua</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Ayah/Wali</label>
                    <input type="text" name="nama_wali" class="form-control @error('nama_wali') is-invalid @enderror"
                        value="{{ old('nama_wali') }}" placeholder="Nama lengkap Ayah/Wali (opsional)">
                    @error('nama_wali')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Pekerjaan Ayah/Wali</label>
                    <input type="text" name="pekerjaan_wali" class="form-control @error('pekerjaan_wali') is-invalid @enderror"
                        value="{{ old('pekerjaan_wali') }}" placeholder="Contoh: Wiraswasta / PNS / Petani">
                    @error('pekerjaan_wali')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Ibu/Wali <span class="text-danger">*</span></label>
                    <input type="text" name="nama_ibu" required class="form-control @error('nama_ibu') is-invalid @enderror"
                        value="{{ old('nama_ibu') }}" placeholder="Nama lengkap Ibu/Wali (wajib diisi)">
                    @error('nama_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Pekerjaan Ibu/Wali</label>
                    <input type="text" name="pekerjaan_ibu" class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                        value="{{ old('pekerjaan_ibu') }}" placeholder="Contoh: Ibu Rumah Tangga / Guru / Wiraswasta">
                    @error('pekerjaan_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i> Simpan</button>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
