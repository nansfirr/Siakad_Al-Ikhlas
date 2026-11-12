@extends('layouts.app')

@section('title','Tambah Kategori')

@section('content')

<div class="card shadow-sm">

<div class="card-header">

Tambah Kategori Kegiatan

</div>

<div class="card-body">

<form action="{{ route('admin.katagori.store') }}" method="POST">

@csrf

<div class="mb-3">

<label class="form-label">

Nama Kategori

</label>

<input
type="text"
name="nama_katagori"
class="form-control"
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
required>

</div>

<button class="btn btn-success">

Simpan

</button>

<a href="{{ route('admin.katagori.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

@endsection