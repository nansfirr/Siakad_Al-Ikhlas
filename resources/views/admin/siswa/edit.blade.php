@extends('layouts.app')
@section('title', 'Edit Siswa')
@section('content')
<div class="card border-0 shadow-sm" style="max-width:850px">
    <div class="card-header bg-white py-3">
        <h6 class="fw-bold mb-0"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Data Siswa & Orang Tua</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.siswa.update', $siswa->id_siswa) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <h6 class="fw-bold text-success border-bottom pb-2 mb-3">A. Data Pribadi Siswa</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">NIS <span class="text-danger">*</span></label>
                    <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
                        value="{{ old('nis', $siswa->nis) }}">
                    @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kelas / Kelompok <span class="text-danger">*</span></label>
                    <select name="id_kelas" class="form-select @error('id_kelas') is-invalid @enderror">
                        @foreach($kelas as $k)
                            <option value="{{ $k->id_kelas }}"
                                {{ old('id_kelas', $siswa->id_kelas) == $k->id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} ({{ $k->tahun_ajaran }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Nama Lengkap Anak/Siswa <span class="text-danger">*</span></label>
                    <input type="text" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror"
                        value="{{ old('nama_siswa', $siswa->nama_siswa) }}">
                    @error('nama_siswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
                        value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? 'Taliwang') }}" placeholder="Contoh: Taliwang">
                    @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                    @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Anak Ke-</label>
                    <input type="text" name="anak_ke" class="form-control @error('anak_ke') is-invalid @enderror"
                        value="{{ old('anak_ke', $siswa->anak_ke) }}" placeholder="Contoh: 1 / Pertama">
                    @error('anak_ke')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Agama</label>
                    <select name="agama" class="form-select @error('agama') is-invalid @enderror">
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agm)
                            <option value="{{ $agm }}" {{ old('agama', $siswa->agama ?? 'Islam') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                        @endforeach
                    </select>
                    @error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kewarganegaraan</label>
                    <input type="text" name="kewarganegaraan" class="form-control @error('kewarganegaraan') is-invalid @enderror"
                        value="{{ old('kewarganegaraan', $siswa->kewarganegaraan ?? 'Indonesia') }}">
                    @error('kewarganegaraan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Alamat tempat tinggal siswa">{{ old('alamat', $siswa->alamat) }}</textarea>
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Foto Siswa</label>
                    @if($siswa->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$siswa->foto) }}" height="80"
                                class="rounded border" style="object-fit:cover">
                            <small class="text-muted d-block">Foto saat ini</small>
                        </div>
                    @endif
                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                    @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <h6 class="fw-bold text-success border-bottom pb-2 mb-3">B. Data Orang Tua / Wali</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Ayah / Wali <span class="text-danger">*</span></label>
                    <input type="text" name="nama_wali" class="form-control @error('nama_wali') is-invalid @enderror"
                        value="{{ old('nama_wali', $siswa->nama_wali) }}" placeholder="Nama lengkap Ayah/Wali">
                    @error('nama_wali')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Pekerjaan Ayah / Wali</label>
                    <input type="text" name="pekerjaan_wali" class="form-control @error('pekerjaan_wali') is-invalid @enderror"
                        value="{{ old('pekerjaan_wali', $siswa->pekerjaan_wali) }}" placeholder="Contoh: Wiraswasta / PNS / Petani">
                    @error('pekerjaan_wali')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Ibu / Wali</label>
                    <input type="text" name="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror"
                        value="{{ old('nama_ibu', $siswa->nama_ibu) }}" placeholder="Nama lengkap Ibu/Wali">
                    @error('nama_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Pekerjaan Ibu / Wali</label>
                    <input type="text" name="pekerjaan_ibu" class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                        value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}" placeholder="Contoh: Ibu Rumah Tangga / Guru / Wiraswasta">
                    @error('pekerjaan_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg me-1"></i> Update</button>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
