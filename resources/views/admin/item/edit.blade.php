@extends('layouts.app')

@section('title','Edit Item Kegiatan')

@section('content')

<div class="card shadow-sm">

<div class="card-header">

Edit Item Kegiatan

</div>

<div class="card-body">

<form
action="{{ route('admin.item.update',$data->id_item) }}"
method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Kategori</label>

<select
name="id_katagori"
class="form-control">

@foreach($katagori as $k)

<option
value="{{ $k->id_katagori }}"
{{ $data->id_katagori==$k->id_katagori?'selected':'' }}>

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
value="{{ $data->nama_item }}"
class="form-control">

</div>

<div class="mb-3">

<label>Urutan</label>

<input
type="number"
name="urutan"
value="{{ $data->urutan }}"
class="form-control">

</div>

<button class="btn btn-primary">

Update

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