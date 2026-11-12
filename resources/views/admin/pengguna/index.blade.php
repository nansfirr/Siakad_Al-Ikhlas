@extends('layouts.app')
@section('title', 'Data Pengguna')
@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Data Pengguna</h6>
        <a href="{{ route('admin.pengguna.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Pengguna
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengguna as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->email }}</td>
                    <td>
                        <span class="badge {{ $p->role == 'guru' ? 'bg-primary' : 'bg-info' }}">
                            {{ ucfirst($p->role) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.pengguna.edit', $p->id) }}"
                            class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.pengguna.destroy', $p->id) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin hapus pengguna ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection