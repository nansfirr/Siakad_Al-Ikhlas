@extends('layouts.app')

@section('content')

<div class="container mt-3">

    <h4>Edit Aspek</h4>

    <form method="POST" action="{{ route('admin.aspek.update', $data->id_aspek) }}">
        @csrf
        @method('PUT')

        <div class="mb-2">
            <label>Nama Aspek</label>
            <input type="text" name="nama_aspek" class="form-control" value="{{ $data->nama_aspek }}" required>
        </div>

        <div class="mb-2">
            <label>Urutan</label>
            <input type="number" name="urutan" class="form-control" value="{{ $data->urutan }}" required>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>

</div>

@endsection