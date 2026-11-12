@extends('layouts.app')

@section('content')

<div class="container mt-3">

    <h4>Aspek Perkembangan</h4>

    <a href="{{ route('admin.aspek.create') }}" class="btn btn-primary btn-sm mb-3">
        + Tambah
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Aspek</th>
            <th>Urutan</th>
            <th>Aksi</th>
        </tr>

        @foreach($data as $i => $d)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $d->nama_aspek }}</td>
            <td>{{ $d->urutan }}</td>
            <td>
                <a href="{{ route('admin.aspek.edit', $d->id_aspek) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('admin.aspek.destroy', $d->id_aspek) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>

</div>

@endsection