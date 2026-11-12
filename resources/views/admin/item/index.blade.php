@extends('layouts.app')

@section('title','Item Kegiatan')

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">Data Item Kegiatan</h5>

        <a href="{{ route('admin.item.create') }}" class="btn btn-success">
            Tambah Item
        </a>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

            <tr>
                <th width="60">No</th>
                <th>Kategori</th>
                <th>Nama Item</th>
                <th width="80">Urutan</th>
                <th width="180">Aksi</th>
            </tr>

            </thead>

            <tbody>

            @foreach($data as $i=>$d)

            <tr>

                <td>{{ $i+1 }}</td>

                <td>{{ $d->katagori->nama_katagori }}</td>

                <td>{{ $d->nama_item }}</td>

                <td>{{ $d->urutan }}</td>

                <td>

                    <a href="{{ route('admin.item.edit',$d->id_item) }}"
                        class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form
                        action="{{ route('admin.item.destroy',$d->id_item) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Yakin hapus?')"
                            class="btn btn-danger btn-sm">

                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

            @endforeach

            </tbody>

        </table>

    </div>
</div>

@endsection