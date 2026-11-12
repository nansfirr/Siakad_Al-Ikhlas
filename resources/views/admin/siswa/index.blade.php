@extends('layouts.app')
@section('title', 'Data Siswa')
@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Data Siswa</h6>
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Siswa
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Jenis Kelamin</th>
                    <th>Nama Wali</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        @if($s->foto)
                            <img src="{{ asset('storage/'.$s->foto) }}"
                                class="rounded-circle" width="40" height="40"
                                style="object-fit:cover">
                        @else
                            <div class="bg-secondary rounded-circle d-flex align-items-center
                                justify-content-center text-white" style="width:40px;height:40px">
                                <i class="bi bi-person"></i>
                            </div>
                        @endif
                    </td>
                    <td>{{ $s->nis }}</td>
                    <td>{{ $s->nama_siswa }}</td>
                    <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $s->nama_wali }}</td>
                    <td>
                        <a href="{{ route('admin.siswa.edit', $s->id_siswa) }}"
                            class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.siswa.destroy', $s->id_siswa) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin hapus siswa ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada data siswa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection