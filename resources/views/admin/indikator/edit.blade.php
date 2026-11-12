@extends('layouts.app')

@section('title','Edit Indikator Penilaian')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">Edit Indikator Penilaian</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.indikator.update', $indikator->id_indikator) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label class="form-label">Aspek Perkembangan</label>

                <select name="id_aspek" class="form-select" required>

                    @foreach($aspek as $a)

                        <option value="{{ $a->id_aspek }}"
                            {{ $indikator->id_aspek == $a->id_aspek ? 'selected' : '' }}>

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
                    required>{{ old('capaian_pembelajaran', $indikator->capaian_pembelajaran) }}</textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">Urutan</label>

                <input
                    type="number"
                    name="urutan"
                    class="form-control"
                    value="{{ old('urutan', $indikator->urutan) }}"
                    required>

            </div>

            <button class="btn btn-primary">
                Update
            </button>

            <a href="{{ route('admin.indikator.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>

@endsection