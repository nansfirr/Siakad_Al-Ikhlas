@extends('layouts.app')
@section('title', 'Penilaian Kegiatan — '.$siswa->nama_siswa)
@section('content')

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h6 class="fw-bold mb-0">{{ $siswa->nama_siswa }}</h6>
            <small class="text-muted">NIS: {{ $siswa->nis }} | Semester {{ $semester }}</small>
        </div>
        <a href="{{ route('guru.kegiatan.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="{{ route('guru.kegiatan.store', $siswa->id_siswa) }}" method="POST">
    @csrf
    <input type="hidden" name="semester" value="{{ $semester }}">
    <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">

    @foreach($katagori as $kat)
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-success text-white">
            <h6 class="mb-0">{{ $kat->urutan }}. {{ $kat->nama_katagori }}</h6>
        </div>
        <div class="card-body">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Item Penilaian</th>
                        <th class="text-center">BB</th>
                        <th class="text-center">MB</th>
                        <th class="text-center">BSH</th>
                        <th class="text-center">BSB</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kat->itemKegiatan as $item)
                    @php $existing = $nilaiExisting[$item->id_item] ?? null; @endphp
                    <tr>
                        <td>{{ $item->urutan }}</td>
                        <td>{{ $item->nama_item }}</td>
                        @foreach(['BB','MB','BSH','BSB'] as $nilai)
                        @php
                            $valPilih = old("nilai.{$item->id_item}.nilai", $existing?->nilai ?? '');
                        @endphp
                        <td class="text-center">
                            <input type="radio"
                                name="nilai[{{ $item->id_item }}][nilai]"
                                value="{{ $nilai }}"
                                class="form-check-input"
                                {{ $valPilih == $nilai ? 'checked' : '' }}>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

    <div class="d-flex gap-2 mb-4">
        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Simpan Penilaian Kegiatan
        </button>
        <a href="{{ route('guru.kegiatan.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</form>
@endsection