@extends('layouts.app')

@section('title','Kategori Kegiatan')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Kategori Kegiatan</h5>

        <a href="{{ route('admin.katagori.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i>
            Tambah
        </a>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead class="table-success">
            <tr>
                <th width="70">No</th>
                <th>Nama Kategori</th>
                <th width="100">Urutan</th>
                <th width="170">Aksi</th>
            </tr>
            </thead>

            <tbody>

            @forelse($data as $i=>$d)

                <tr>

                    <td>{{ $i+1 }}</td>

                    <td>{{ $d->nama_katagori }}</td>

                    <td>{{ $d->urutan }}</td>

                    <td>

                        <a href="{{ route('admin.katagori.edit',$d->id_katagori) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form
                            action="{{ route('admin.katagori.destroy',$d->id_katagori) }}"
                            method="POST"
                            style="display:inline">

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus data ini?')">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="4" class="text-center">
                        Belum ada data.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection