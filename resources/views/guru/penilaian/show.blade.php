@extends('layouts.app')

@section('title', 'Input Penilaian — '.$siswa->nama_siswa)

@section('content')

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h5 class="fw-bold mb-1">{{ $siswa->nama_siswa }}</h5>
            <small class="text-muted">
                NIS : {{ $siswa->nis }} |
                Semester {{ $semester }}
            </small>
        </div>

        <a href="{{ route('guru.penilaian.index', ['id_kelas' => $siswa->id_kelas, 'semester' => $semester]) }}" class="btn btn-secondary btn-sm">
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
@php
    $jmlIndAspek = $a->indikatorPenilaian->count();
    $terisiAspek = 0;
    foreach ($a->indikatorPenilaian as $indCheck) {
        if (!empty($penilaianExisting[$indCheck->id_indikator]->nilai ?? null)) {
            $terisiAspek++;
        }
    }
@endphp

<div class="card shadow-sm border-0 mb-4" id="card-aspek-{{ $a->id_aspek }}">

    <div class="card-header bg-success text-white d-flex flex-wrap justify-content-between align-items-center gap-2 py-2">
        <div>
            <strong>{{ $a->urutan }}. {{ $a->nama_aspek }}</strong>
            @if($terisiAspek == $jmlIndAspek && $jmlIndAspek > 0)
                <span class="badge bg-light text-success ms-2">
                    <i class="bi bi-check-circle-fill"></i> {{ $terisiAspek }}/{{ $jmlIndAspek }} Terisi
                </span>
            @else
                <span class="badge bg-warning text-dark ms-2">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ $terisiAspek }}/{{ $jmlIndAspek }} Terisi
                </span>
            @endif
        </div>

        <div class="d-flex align-items-center gap-1">
            <small class="text-white-50 me-1 d-none d-sm-inline">Isi Cepat:</small>
            @foreach(['BB','MB','BSH','BSB'] as $nCepat)
                <button type="button"
                        class="btn btn-light btn-sm py-0 px-2 fw-bold text-success"
                        style="font-size: 0.75rem;"
                        onclick="setAspekNilai({{ $a->id_aspek }}, '{{ $nCepat }}')">
                    Semua {{ $nCepat }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="card-body">

        {{-- ===================== --}}
        {{-- TABLE PENILAIAN --}}
        {{-- ===================== --}}
        <div class="table-responsive mb-3">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="6%">No</th>
                        <th>Capaian Pembelajaran</th>
                        <th width="9%" class="text-center">BB</th>
                        <th width="9%" class="text-center">MB</th>
                        <th width="9%" class="text-center">BSH</th>
                        <th width="9%" class="text-center">BSB</th>
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
                                @php
                                    $valPilih = old("penilaian.{$ind->id_indikator}.nilai", $existing?->nilai ?? '');
                                @endphp
                                <td class="text-center">
                                    <input type="radio"
                                        name="penilaian[{{ $ind->id_indikator }}][nilai]"
                                        value="{{ $nilai }}"
                                        data-aspek="{{ $a->id_aspek }}"
                                        class="form-check-input radio-aspek-{{ $a->id_aspek }}"
                                        style="width: 1.25em; height: 1.25em; cursor: pointer;"
                                        {{ $valPilih == $nilai ? 'checked' : '' }}>
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
            <label class="form-label fw-bold">Deskripsi Perkembangan ({{ $a->nama_aspek }})</label>
            <textarea name="deskripsi[{{ $a->id_aspek }}]"
                      class="form-control"
                      rows="3"
                      placeholder="Tuliskan deskripsi capaian perkembangan untuk aspek {{ $a->nama_aspek }}...">{{ old("deskripsi.{$a->id_aspek}", $deskripsiAspek[$a->id_aspek]->deskripsi ?? '') }}</textarea>
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
                        <div class="border rounded p-4 mb-2 text-muted small">
                            Belum Ada Foto {{ $i + 1 }}
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
    <button type="submit" class="btn btn-success btn-lg w-100 w-md-auto px-5">
        <i class="bi bi-save me-1"></i> Simpan Penilaian (Semua Aspek)
    </button>
</div>

</form>

<script>
    function setAspekNilai(idAspek, nilaiTarget) {
        document.querySelectorAll('.radio-aspek-' + idAspek).forEach((radio) => {
            if (radio.value === nilaiTarget) {
                radio.checked = true;
            }
        });
    }
</script>

@endsection
