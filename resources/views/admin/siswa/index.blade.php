@extends('layouts.app')
@section('title', 'Data Siswa')
@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="fw-bold mb-0">Data Siswa & Orang Tua</h6>
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Siswa
        </a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>NIS</th>
                    <th>Nama Siswa & TTL</th>
                    <th>Kelas</th>
                    <th>L/P</th>
                    <th>Ayah/Wali</th>
                    <th>Ibu/Wali</th>
                    <th>Alamat</th>
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
                    <td>
                        <div class="fw-semibold">{{ $s->nama_siswa }}</div>
                        <small class="text-muted">
                            {{ $s->tempat_lahir ?? 'Taliwang' }}, {{ $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                            @if($s->anak_ke) • Anak ke-{{ $s->anak_ke }} @endif
                        </small>
                    </td>
                    <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $s->jenis_kelamin }}</td>
                    <td>
                        <div>{{ $s->nama_wali ?? '-' }}</div>
                        @if($s->pekerjaan_wali)
                            <small class="text-muted">{{ $s->pekerjaan_wali }}</small>
                        @endif
                    </td>
                    <td>
                        <div>{{ $s->nama_ibu ?? '-' }}</div>
                        @if($s->pekerjaan_ibu)
                            <small class="text-muted">{{ $s->pekerjaan_ibu }}</small>
                        @endif
                    </td>
                    <td><small>{{ $s->alamat ?? '-' }}</small></td>
                    <td>
                        <a href="{{ route('admin.siswa.edit', $s->id_siswa) }}"
                            class="btn btn-warning btn-sm" title="Edit Biodata">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.siswa.destroy', $s->id_siswa) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin hapus siswa ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted">Belum ada data siswa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
