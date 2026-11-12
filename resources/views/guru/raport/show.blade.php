@extends('layouts.app')

@section('title','Preview Raport')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">

    <h3 class="mb-0">
        Preview Raport
    </h3>

    <div>

        <a href="{{ route('guru.raport.index') }}"
           class="btn btn-secondary">

            Kembali

        </a>

        <a href="{{ route('guru.raport.pdf',$siswa->id_siswa) }}"
           class="btn btn-success">

            Cetak PDF

        </a>

    </div>

</div>

<iframe
    src="{{ route('guru.raport.pdf',$siswa->id_siswa) }}"
    width="100%"
    height="900"
    style="border:1px solid #ddd;border-radius:8px;">
</iframe>

@endsection