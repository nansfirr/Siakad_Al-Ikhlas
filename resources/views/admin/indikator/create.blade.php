@extends('layouts.app')

@section('title','Tambah Indikator Penilaian')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">Tambah Indikator Penilaian</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.indikator.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label class="form-label">Aspek Perkembangan</label>

                <select name="id_aspek" class="form-select" required>

                    <option value="">-- Pilih Aspek --</option>

                    @foreach($aspek as $a)
                        <option value="{{ $a->id_aspek }}">
                            {{ $a->nama_aspek }}
                        </option>
                    @endforeach

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">Capaian Pembelajaran</label>

                <textarea
                    name="capaian_pembelajaran"
                    rows="4"
                    class="form-control"
                    required>{{ old('capaian_pembelajaran') }}</textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">Urutan</label>

                <input
                    type="number"
                    name="urutan"
                    class="form-control"
                    value="{{ old('urutan') }}"
                    required>

            </div>

            <button class="btn btn-success">
                Simpan
            </button>

            <a href="{{ route('admin.indikator.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>

@endsection