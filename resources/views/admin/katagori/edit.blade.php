@extends('layouts.app')

@section('title','Edit Kategori')

@section('content')

<div class="card shadow-sm">

<div class="card-header">

Edit Kategori Kegiatan

</div>

<div class="card-body">

<form action="{{ route('admin.katagori.update',$data->id_katagori) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label class="form-label">

Nama Kategori

</label>

<input
type="text"
name="nama_katagori"
class="form-control"
value="{{ $data->nama_katagori }}"
required>

</div>

<div class="mb-3">

<label class="form-label">

Urutan

</label>

<input
type="number"
name="urutan"
class="form-control"
value="{{ $data->urutan }}"
required>

</div>

<button class="btn btn-success">

Update

</button>

<a href="{{ route('admin.katagori.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

@endsection