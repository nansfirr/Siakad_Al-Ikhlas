@extends('layouts.app')

@section('content')

<div class="container mt-3">

    <h4>Tambah Aspek</h4>

    <form method="POST" action="{{ route('admin.aspek.store') }}">
        @csrf

        <div class="mb-2">
            <label>Nama Aspek</label>
            <input type="text" name="nama_aspek" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Urutan</label>
            <input type="number" name="urutan" class="form-control" required>
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>

</div>

@endsection