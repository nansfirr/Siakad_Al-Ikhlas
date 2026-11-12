@extends('layouts.app')

@section('title', 'Laporan Perkembangan')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header">
            <h4 class="mb-0">Laporan Perkembangan Seluruh Siswa</h4>
        </div>

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-3">
                        <label>Kelas</label>
                        <select name="id_kelas" class="form-control">
                            <option value="">Semua Kelas</option>

                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}"
                                    {{ $kelasId == $k->id_kelas ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Semester</label>

                        <select name="semester" class="form-control">
                            <option value="1" {{ $semester == 1 ? 'selected' : '' }}>
                                Semester 1
                            </option>

                            <option value="2" {{ $semester == 2 ? 'selected' : '' }}>
                                Semester 2
                            </option>
                        </select>

                    </div>

                    <div class="col-md-3">
                        <label>Tahun Ajaran</label>

                        <input
                            type="text"
                            name="tahun_ajaran"
                            class="form-control"
                            value="{{ $tahunAjaran }}">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            Tampilkan
                        </button>
                    </div>

                </div>

            </form>

            <hr>

            <table class="table table-bordered table-striped">

                <thead class="table-light">

                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>

                        @foreach($aspek as $a)
                            <th class="text-center">
                                {{ $a->nama_aspek }}
                            </th>
                        @endforeach

                    </tr>

                </thead>

                <tbody>

                    @forelse($siswa as $i => $s)

                        <tr>

                            <td>{{ $i + 1 }}</td>

                            <td>{{ $s->nama_siswa }}</td>

                            <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>

                            @foreach($aspek as $a)

                                <td class="text-center">

                                    {{ $rekapNilai[$s->id_siswa][$a->id_aspek] ?? '-' }}

                                </td>

                            @endforeach

                        </tr>

                    @empty

                        <tr>

                            <td colspan="{{ count($aspek) + 3 }}" class="text-center">

                                Belum ada data.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection