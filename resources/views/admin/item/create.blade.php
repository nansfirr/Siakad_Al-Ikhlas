@extends('layouts.app')

@section('title','Tambah Item Kegiatan')

@section('content')

<div class="card shadow-sm">

<div class="card-header">
Tambah Item Kegiatan
</div>

<div class="card-body">

<form action="{{ route('admin.item.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Kategori</label>

<select name="id_katagori" class="form-control">

@foreach($katagori as $k)

<option value="{{ $k->id_katagori }}">
{{ $k->nama_katagori }}
</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label>Nama Item</label>

<input
type="text"
name="nama_item"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Urutan</label>

<input
type="number"
name="urutan"
class="form-control"
required>

</div>

<button class="btn btn-success">

Simpan

</button>

<a
href="{{ route('admin.item.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

@endsection