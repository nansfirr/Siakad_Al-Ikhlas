@extends('layouts.app')

@section('title', 'Pengaturan Sekolah')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">
            Pengaturan Sekolah
        </h5>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.pengaturan.update') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="row">

                <div class="col-md-4 text-center">

                    @if($pengaturan->logo)

                        <img src="{{ asset('storage/'.$pengaturan->logo) }}"
                             class="img-thumbnail mb-3"
                             style="max-width:220px">

                    @else

                        <div class="border rounded p-5 text-muted">
                            Belum ada logo
                        </div>

                    @endif

                    <input
                        type="file"
                        name="logo"
                        class="form-control mt-3">

                </div>


                <div class="col-md-8">

                    <div class="mb-3">

                        <label class="form-label">
                            Nama Sekolah
                        </label>

                        <input
                            type="text"
                            name="nama_sekolah"
                            class="form-control"
                            value="{{ old('nama_sekolah',$pengaturan->nama_sekolah) }}">

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Alamat
                        </label>

                        <textarea
                            name="alamat"
                            rows="3"
                            class="form-control">{{ old('alamat',$pengaturan->alamat) }}</textarea>

                    </div>


                    <div class="row">

                        <div class="col-md-6">

                            <div class="mb-3">

                                <label class="form-label">
                                    Nomor Telepon
                                </label>

                                <input
                                    type="text"
                                    name="telepon"
                                    class="form-control"
                                    value="{{ old('telepon',$pengaturan->telepon) }}">

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="mb-3">

                                <label class="form-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    value="{{ old('email',$pengaturan->email) }}">

                            </div>

                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-6">

                            <div class="mb-3">

                                <label class="form-label">
                                    Kepala Sekolah
                                </label>

                                <input
                                    type="text"
                                    name="kepala_sekolah"
                                    class="form-control"
                                    value="{{ old('kepala_sekolah',$pengaturan->kepala_sekolah) }}">

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="mb-3">

                                <label class="form-label">
                                    NIP Kepala Sekolah
                                </label>

                                <input
                                    type="text"
                                    name="nip_kepala"
                                    class="form-control"
                                    value="{{ old('nip_kepala',$pengaturan->nip_kepala) }}">

                            </div>

                        </div>

                    </div>

                    <button class="btn btn-success">

                        <i class="bi bi-check-circle"></i>

                        Simpan Pengaturan

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection