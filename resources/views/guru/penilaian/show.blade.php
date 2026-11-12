@extends('layouts.app')

@section('title', 'Input Penilaian — '.$siswa->nama_siswa)

@section('content')

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-1">{{ $siswa->nama_siswa }}</h5>
            <small class="text-muted">
                NIS : {{ $siswa->nis }} |
                Semester {{ $semester }}
            </small>
        </div>

        <a href="{{ route('guru.penilaian.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="{{ route('guru.penilaian.store',$siswa->id_siswa) }}"
      method="POST"
      enctype="multipart/form-data">

@csrf

<input type="hidden" name="semester" value="{{ $semester }}">

@foreach($aspek as $a)

<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-success text-white">
        <strong>{{ $a->urutan }}. {{ $a->nama_aspek }}</strong>
    </div>

    <div class="card-body">

        {{-- ===================== --}}
        {{-- TABLE PENILAIAN --}}
        {{-- ===================== --}}
        <div class="table-responsive mb-3">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Capaian Pembelajaran</th>
                        <th class="text-center">BB</th>
                        <th class="text-center">MB</th>
                        <th class="text-center">BSH</th>
                        <th class="text-center">BSB</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($a->indikatorPenilaian as $ind)

                        @php
                            $existing = $penilaianExisting[$ind->id_indikator] ?? null;
                        @endphp

                        <tr>
                            <td class="text-center">{{ $ind->urutan }}</td>
                            <td>{{ $ind->capaian_pembelajaran }}</td>

                            @foreach(['BB','MB','BSH','BSB'] as $nilai)
                                <td class="text-center">
                                    <input type="radio"
                                        name="penilaian[{{ $ind->id_indikator }}][nilai]"
                                        value="{{ $nilai }}"
                                        class="form-check-input"
                                        {{ ($existing?->nilai ?? '') == $nilai ? 'checked' : '' }}
                                        required>
                                </td>
                            @endforeach
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ===================== --}}
        {{-- DESKRIPSI --}}
        {{-- ===================== --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Deskripsi Perkembangan</label>
            <textarea name="deskripsi[{{ $a->id_aspek }}]"
                      class="form-control"
                      rows="3">{{ $deskripsiAspek[$a->id_aspek]->deskripsi ?? '' }}</textarea>
        </div>

        {{-- ===================== --}}
        {{-- FOTO (MAX 3) --}}
        {{-- ===================== --}}
        <div class="row">

            @for($i = 0; $i < 3; $i++)

                @php
                    $foto = $deskripsiAspek[$a->id_aspek]->{'foto'.($i+1)} ?? null;
                @endphp

                <div class="col-md-4 text-center mb-3">

                    @if($foto)
                        <img src="{{ asset('storage/'.$foto) }}"
                             class="img-thumbnail mb-2"
                             style="height:120px; object-fit:cover;">
                    @else
                        <div class="border p-4 mb-2 text-muted">
                            No Image
                        </div>
                    @endif

                    <input type="file"
                           name="foto[{{ $a->id_aspek }}][{{ $i }}]"
                           class="form-control form-control-sm"
                           accept="image/*">

                </div>

            @endfor

        </div>

    </div>
</div>

@endforeach

<div class="mb-5">
    <button class="btn btn-success">
        <i class="bi bi-save"></i> Simpan Penilaian
    </button>
</div>

</form>

@endsection