@extends('layouts.app')

@section('title','Raport')

@section('content')

@if(session('error'))

<div class="alert alert-danger">
    {!! nl2br(e(session('error'))) !!}
</div>

@endif

@if(session('success'))

<div class="alert alert-success">
    {{ session('success') }}
</div>

@endif

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">
            Raport Siswa
        </h4>

        <form method="GET">

            <select
                name="id_kelas"
                class="form-select"
                onchange="this.form.submit()">

                <option value="semua" {{ $kelasId == 'semua' ? 'selected' : '' }}>
                    -- Semua Kelas --
                </option>

                @foreach($kelasSaya as $kelas)

                    <option
                        value="{{ $kelas->id_kelas }}"
                        {{ $kelasId==$kelas->id_kelas ? 'selected' : '' }}>

                        {{ $kelas->nama_kelas }}

                    </option>

                @endforeach

            </select>

        </form>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped align-middle">

            <thead class="table-success">

                <tr>

                    <th width="5%">No</th>

                    <th>Nama Siswa</th>

                    <th width="18%">Status</th>

                    <th width="32%">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($siswa as $item)

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>

                        <strong>{{ $item->nama_siswa }}</strong>

                    </td>

                    <td class="text-center">

                        @if($item->statusRaport)

                            <span class="badge bg-success">

                                Lengkap

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Belum Lengkap

                            </span>

                        @endif

                    </td>

                    <td>

                        <a
                            href="{{ route('guru.siswa.edit',$item->id_siswa) }}"
                            class="btn btn-warning btn-sm">

                            ✏️ Biodata

                        </a>

                        <a
                            href="{{ route('guru.raport.show',$item->id_siswa) }}"
                            class="btn btn-primary btn-sm">

                            👁 Preview

                        </a>

                        @if($item->statusRaport)

                            <a
                                href="{{ route('guru.raport.pdf',$item->id_siswa) }}"
                                class="btn btn-success btn-sm">

                                📄 Cetak PDF

                            </a>

                        @else

                            <button
                                class="btn btn-secondary btn-sm"
                                disabled>

                                Lengkapi Data

                            </button>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4" class="text-center">

                        Belum ada siswa.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection