@extends('layouts.app')

@section('title','Indikator Penilaian')

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Indikator Penilaian</h5>

        <a href="{{ route('admin.indikator.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">
            <thead class="table-success">
                <tr>
                    <th width="50">No</th>
                    <th>Aspek</th>
                    <th>Indikator</th>
                    <th width="80">Urutan</th>
                    <th width="170">Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($indikator as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->aspek->nama_aspek }}</td>

                    <td>{{ $item->capaian_pembelajaran }}</td>

                    <td>{{ $item->urutan }}</td>

                    <td>

                        <a href="{{ route('admin.indikator.edit',$item->id_indikator) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form
                            action="{{ route('admin.indikator.destroy',$item->id_indikator) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Hapus indikator ini?')"
                                class="btn btn-danger btn-sm">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada data.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection