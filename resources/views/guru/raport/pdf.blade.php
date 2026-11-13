<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>
Raport {{ $siswa->nama_siswa }}
</title>

<style>

@page {
    margin: 20px 30px;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    color: #000;
    line-height: 1.5;
}

table {
    width: 100%;
    border-collapse: collapse;
}

td, th {
    border: 1px solid #000;
    padding: 5px;
    vertical-align: top;
}

.center {
    text-align: center;
}

.right {
    text-align: right;
}

.bold {
    font-weight: bold;
}

.logo {
    width: 85px;
    height: auto;
}

.header {
    text-align: center;
    margin-bottom: 10px;
}

.header h3 {
    margin: 3px;
    font-size: 16px;
}

.header h4 {
    margin: 2px;
    font-size: 13px;
    font-weight: normal;
}

.section {
    background: #d9ead3;
    padding: 8px;
    border: 1px solid #000;
    font-weight: bold;
    margin-top: 10px;
    margin-bottom: 8px;
}

.info td {
    border: none;
    padding: 3px;
}

.nilai th {
    background: #eeeeee;
    text-align: center;
}

.deskripsi {
    border: 1px solid #000;
    padding: 10px;
    min-height: 80px;
    text-align: justify;
}

.foto {
    width: 155px;
    height: 155px;
    border: 1px solid #000;
    object-fit: cover;
}

.foto-kosong {
    width: 155px;
    height: 155px;
    border: 1px solid #000;
}

.cover {
    margin-top: 60px;
    text-align: center;
}

.cover h2 {
    margin-top: 20px;
    margin-bottom: 5px;
    font-size: 22px;
}

.cover h3 {
    margin: 5px;
    font-size: 18px;
}

.cover h4 {
    margin: 3px;
    font-size: 14px;
    font-weight: normal;
}

.page-break {
    page-break-after: always;
}

.ttd td {
    border: none;
    text-align: center;
}

.page-number {
    font-size: 9px;
    color: #555;
    margin-bottom: 5px;
}

.star {
    font-size: 12px;
}

</style>

</head>

<body>

{{-- ===================== --}}
{{-- HALAMAN 1: COVER --}}
{{-- ===================== --}}

<div class="cover">

@if(!empty($pengaturan->logo))
<img
    src="{{ public_path('storage/'.$pengaturan->logo) }}"
    style="width:100px;height:auto;">
@endif

<h2>
LAPORAN PENCAPAIAN<br>
PERKEMBANGAN ANAK
</h2>

<h4>(LPPA)</h4>

<h3>
{{ strtoupper($pengaturan->nama_sekolah ?? 'TK AL-IKHLAS TALIWANG') }}
</h3>

<br><br>

<table
    class="info"
    style="width:70%;margin:auto;">

<tr>
<td width="35%">Nama Siswa</td>
<td width="5%">:</td>
<td><b>{{ strtoupper($siswa->nama_siswa) }}</b></td>
</tr>

<tr>
<td>Kelompok</td>
<td>:</td>
<td>{{ $siswa->kelas->nama_kelas }}</td>
</tr>

</table>

<br><br><br>

@if(!empty($pengaturan->nama_yayasan))
<p style="font-size:12px;">
{{ strtoupper($pengaturan->nama_yayasan) }}
</p>
@endif

<p style="font-size:12px;">
<b>{{ strtoupper($pengaturan->nama_sekolah ?? 'TK AL-IKHLAS TALIWANG') }}</b>
</p>

<p style="font-size:12px;">
Semester {{ $semester == 1 ? 'Ganjil' : 'Genap' }} Tahun Ajaran {{ $tahun_ajaran }}
</p>

</div>

<div class="page-break"></div>

{{-- ========================================= --}}
{{-- HALAMAN 2: PETUNJUK PENILAIAN --}}
{{-- ========================================= --}}

<div class="header">

@if(!empty($pengaturan->logo))
<img src="{{ public_path('storage/'.$pengaturan->logo) }}" class="logo">
@endif

<h3>
PENILAIAN PROGRAM PENGEMBANGAN PESERTA DIDIK
</h3>

</div>

<br>

<table>

<tr style="background:#eeeeee;">
<th width="18%">Kode</th>
<th>Keterangan</th>
</tr>

<tr>
<td class="center">BB</td>
<td>Belum Berkembang</td>
</tr>

<tr>
<td class="center">MB</td>
<td>Mulai Berkembang</td>
</tr>

<tr>
<td class="center">BSH</td>
<td>Berkembang Sesuai Harapan</td>
</tr>

<tr>
<td class="center">BSB</td>
<td>Berkembang Sangat Baik</td>
</tr>

</table>

<br>

<div style="padding:10px;text-align:justify;">
Laporan perkembangan anak merupakan hasil pengamatan guru terhadap capaian perkembangan peserta didik selama satu semester. Penilaian dilakukan secara autentik berdasarkan aktivitas belajar anak di sekolah.
</div>

<div class="page-break"></div>

{{-- ========================================= --}}
{{-- HALAMAN 3: DATA PRIBADI SISWA --}}
{{-- ========================================= --}}

<div class="header">

@if(!empty($pengaturan->logo))
<img src="{{ public_path('storage/'.$pengaturan->logo) }}" class="logo">
@endif

<h3>
LAPORAN PENCAPAIAN PERKEMBANGAN ANAK
</h3>

<strong>
{{ strtoupper($pengaturan->nama_sekolah ?? '') }}
</strong>

</div>

<div class="section">
A. DATA PRIBADI SISWA
</div>

<table>

<tr>
<td width="5%" class="center">1.</td>
<td width="35%">Nama lengkap anak/siswa</td>
<td width="3%">:</td>
<td>{{ strtoupper($siswa->nama_siswa) }}</td>
</tr>

<tr>
<td class="center">2.</td>
<td>Tempat/Tgl Lahir</td>
<td>:</td>
<td>{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td>
</tr>

<tr>
<td class="center">3.</td>
<td>Jenis Kelamin</td>
<td>:</td>
<td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
</tr>

<tr>
<td class="center">4.</td>
<td>Anak ke</td>
<td>:</td>
<td>{{ $siswa->anak_ke ?? '-' }}</td>
</tr>

<tr>
<td class="center">5.</td>
<td>Agama</td>
<td>:</td>
<td>{{ $siswa->agama ?? 'Islam' }}</td>
</tr>

<tr>
<td class="center">6.</td>
<td>Kewarganegaraan</td>
<td>:</td>
<td>{{ $siswa->kewarganegaraan ?? 'Indonesia' }}</td>
</tr>

<tr>
<td class="center">7.</td>
<td>Alamat</td>
<td>:</td>
<td>{{ $siswa->alamat ?? '-' }}</td>
</tr>

</table>

<br>

<div class="section">
B. DATA ORANG TUA
</div>

<table>

<tr>
<td width="5%" class="center">8.</td>
<td width="35%">Ayah / Wali :</td>
<td width="3%"></td>
<td></td>
</tr>

<tr>
<td></td>
<td>Nama Ayah/Wali</td>
<td>:</td>
<td>{{ $siswa->nama_wali ?? '-' }}</td>
</tr>

<tr>
<td></td>
<td>Pekerjaan Ayah/Wali</td>
<td>:</td>
<td>{{ $siswa->pekerjaan_wali ?? '-' }}</td>
</tr>

<tr>
<td class="center">9.</td>
<td>Ibu/Wali :</td>
<td></td>
<td></td>
</tr>

<tr>
<td></td>
<td>Nama Ibu/Wali</td>
<td>:</td>
<td>{{ $siswa->nama_ibu ?? '-' }}</td>
</tr>

<tr>
<td></td>
<td>Pekerjaan Ibu/Wali</td>
<td>:</td>
<td>{{ $siswa->pekerjaan_ibu ?? '-' }}</td>
</tr>

</table>

<br><br><br>

<table class="ttd" width="100%">
<tr>
<td width="50%">&nbsp;</td>
<td width="50%">
{{ $pengaturan->alamat ?? 'Taliwang' }}, {{ date('d F Y') }}
<br>
Kepala Sekolah {{ $pengaturan->nama_sekolah ?? '' }}
<br><br><br><br>
<b>{{ $pengaturan->kepala_sekolah ?? '-' }}</b>
<br>
@if(!empty($pengaturan->nip_kepala))
NIP. {{ $pengaturan->nip_kepala }}
@endif
</td>
</tr>
</table>

<div class="page-break"></div>

{{-- ========================================= --}}
{{-- HALAMAN 4+: ASPEK PERKEMBANGAN --}}
{{-- ========================================= --}}

@php
    $hurufAspek = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
@endphp

@foreach($aspek as $aspekIndex => $a)

@php
    $desk = $deskripsi[$a->id_aspek] ?? null;
    $pageNum = $aspekIndex + 1;
    $huruf = $hurufAspek[$aspekIndex] ?? ($aspekIndex + 1);
@endphp

{{-- Page number --}}
<div class="page-number">
{{ $pageNum }} | L C P A
</div>

<div class="header">

<h3>
LAPORAN CAPAIAN PEMBELAJARAN ANAK
</h3>

</div>

<table class="info">

<tr>
<td width="15%">Nama</td>
<td width="3%">:</td>
<td width="35%">{{ $siswa->nama_siswa }}</td>
<td width="15%">Semester</td>
<td width="3%">:</td>
<td>{{ $semester }} ({{ $semester == 1 ? 'Satu' : 'Dua' }})</td>
</tr>

<tr>
<td>Kelompok</td>
<td>:</td>
<td>{{ $siswa->kelas->nama_kelas }}</td>
<td>Tahun Ajaran</td>
<td>:</td>
<td>{{ $tahun_ajaran }}</td>
</tr>

</table>

<div class="section">
{{ $huruf }}. {{ strtoupper($a->nama_aspek) }}
</div>

<table class="nilai">

<thead>
<tr>
<th width="6%">NO</th>
<th>CAPAIAN PEMBELAJARAN {{ strtoupper($a->nama_aspek) }}</th>
<th width="50" colspan="4">TINGKAT KETERCAPAIAN</th>
</tr>

<tr>
<th></th>
<th></th>
<th width="7%">BB</th>
<th width="7%">MB</th>
<th width="7%">BSH</th>
<th width="7%">BSB</th>
</tr>
</thead>

<tbody>

@foreach($a->indikatorPenilaian as $indikator)

@php
    $nilai = $penilaian[$indikator->id_indikator][0]->nilai ?? '';
@endphp

<tr>

<td class="center">
{{ $indikator->urutan }}
</td>

<td>
{{ $indikator->capaian_pembelajaran }}
</td>

<td class="center">
<span class="star">{!! $nilai=='BB' ? '★' : '' !!}</span>
</td>

<td class="center">
<span class="star">{!! $nilai=='MB' ? '★' : '' !!}</span>
</td>

<td class="center">
<span class="star">{!! $nilai=='BSH' ? '★' : '' !!}</span>
</td>

<td class="center">
<span class="star">{!! $nilai=='BSB' ? '★' : '' !!}</span>
</td>

</tr>

@endforeach

</tbody>

</table>

<br>

<b>DESKRIPSI CAPAIAN PERKEMBANGAN</b>

<div class="deskripsi">
{{ $desk->deskripsi ?? '-' }}
</div>

<br>

<b>POSE KEGIATAN {{ strtoupper($a->nama_aspek) }}</b>

<br><br>

<table style="border:none;">

<tr>

<td style="border:none;width:33%;text-align:center;">

@if(!empty($desk->foto1))
<img
    src="{{ public_path('storage/'.$desk->foto1) }}"
    class="foto">
@else
<div class="foto-kosong"></div>
@endif

</td>

<td style="border:none;width:33%;text-align:center;">

@if(!empty($desk->foto2))
<img
    src="{{ public_path('storage/'.$desk->foto2) }}"
    class="foto">
@else
<div class="foto-kosong"></div>
@endif

</td>

<td style="border:none;width:33%;text-align:center;">

@if(!empty($desk->foto3))
<img
    src="{{ public_path('storage/'.$desk->foto3) }}"
    class="foto">
@else
<div class="foto-kosong"></div>
@endif

</td>

</tr>

</table>

<div class="page-break"></div>

@endforeach

{{-- ========================================= --}}
{{-- KEGIATAN TAMBAHAN --}}
{{-- ========================================= --}}

@php
    $kegiatanPageNum = count($aspek) + 1;
@endphp

<div class="page-number">
{{ $kegiatanPageNum }} | L C P A
</div>

<div class="header">

<h3>
LAPORAN CAPAIAN PEMBELAJARAN ANAK
</h3>

</div>

<div class="section">
KEGIATAN TAMBAHAN
</div>

@foreach($katagori as $katIndex => $kategori)

<table width="100%" style="margin-bottom:5px;">
<tr>
<td style="
    background:#eeeeee;
    font-weight:bold;
    padding:6px 8px;
    border:1px solid #000;
">
{{ $katIndex + 1 }}. {{ strtoupper($kategori->nama_katagori) }}
</td>
</tr>
</table>

<table class="nilai">

<thead>
<tr>
<th width="8%">NO.</th>
<th>ASPEK PENILAIAN</th>
<th colspan="4">TINGKAT PERKEMBANGAN</th>
</tr>
<tr>
<th></th>
<th></th>
<th width="7%">BB</th>
<th width="7%">MB</th>
<th width="7%">BSH</th>
<th width="7%">BSB</th>
</tr>
</thead>

<tbody>

@php $no = 1; @endphp

@foreach($kategori->itemKegiatan as $item)

@php
    $nilai = $kegiatan
        ->where('id_item', $item->id_item)
        ->first();
    $nilaiValue = $nilai->nilai ?? '';
@endphp

<tr>

<td class="center">
{{ $no++ }}.
</td>

<td>
{{ $item->nama_item }}
</td>

<td class="center">
<span class="star">{!! $nilaiValue=='BB' ? '★' : '' !!}</span>
</td>

<td class="center">
<span class="star">{!! $nilaiValue=='MB' ? '★' : '' !!}</span>
</td>

<td class="center">
<span class="star">{!! $nilaiValue=='BSH' ? '★' : '' !!}</span>
</td>

<td class="center">
<span class="star">{!! $nilaiValue=='BSB' ? '★' : '' !!}</span>
</td>

</tr>

@endforeach

</tbody>

</table>

<br>

@endforeach

<div class="page-break"></div>

{{-- ========================================= --}}
{{-- REFLEKSI GURU DAN ORANG TUA --}}
{{-- ========================================= --}}

@php
    $refleksiPageNum = count($aspek) + 2;
@endphp

<div class="page-number">
{{ $refleksiPageNum }} | L C P A
</div>

<div class="header">

<h3>
LAPORAN CAPAIAN PEMBELAJARAN ANAK
</h3>

</div>

<div class="section">
REFLEKSI GURU
</div>

<div style="border:1px solid #000;padding:12px;min-height:140px;text-align:justify;">
{{ $refleksiGuru->refleksi ?? '-' }}
</div>

<br>

<div class="section">
REFLEKSI ORANG TUA
</div>

<div style="border:1px solid #000;padding:12px;min-height:140px;">
...........................................................................................................................................
<br><br>
...........................................................................................................................................
<br><br>
...........................................................................................................................................
<br><br>
...........................................................................................................................................
<br><br>
...........................................................................................................................................
</div>

<div class="page-break"></div>

{{-- ========================================= --}}
{{-- PRESENSI DAN ANTROPOMETRI + TTD --}}
{{-- ========================================= --}}

@php
    $presensiPageNum = count($aspek) + 3;
@endphp

<div class="page-number">
{{ $presensiPageNum }} | L C P A
</div>

<div class="header">

<h3>
LAPORAN CAPAIAN PEMBELAJARAN ANAK
</h3>

</div>

<div class="section">
PRESENSI
</div>

<table>

<thead>
<tr style="background:#eeeeee;">
<th width="10%">NO</th>
<th>KEHADIRAN</th>
<th width="20%">KET</th>
</tr>
</thead>

<tbody>

<tr>
<td class="center">1.</td>
<td>Sakit</td>
<td class="center">{{ $presensi->sakit ?? '-' }}</td>
</tr>

<tr>
<td class="center">2.</td>
<td>Izin</td>
<td class="center">{{ $presensi->izin ?? '-' }}</td>
</tr>

<tr>
<td class="center">3.</td>
<td>Tanpa Keterangan</td>
<td class="center">{{ $presensi->alpha ?? '-' }}</td>
</tr>

</tbody>

</table>

<br>

<div class="section">
PERTUMBUHAN ANAK
</div>

<table>

<thead>
<tr style="background:#eeeeee;">
<th width="10%">NO</th>
<th>PERKEMBANGAN</th>
<th width="25%">PENGUKURAN</th>
</tr>
</thead>

<tbody>

<tr>
<td class="center">1</td>
<td>Tinggi Badan</td>
<td class="center">{{ $antropometri->tinggi_badan ?? '-' }} Cm</td>
</tr>

<tr>
<td class="center">2</td>
<td>Berat Badan</td>
<td class="center">{{ $antropometri->berat_badan ?? '-' }} Kg</td>
</tr>

<tr>
<td class="center">3</td>
<td>Lingkar Kepala</td>
<td class="center">{{ $antropometri->lingkar_kepala ?? '-' }} Cm</td>
</tr>

</tbody>

</table>

<br><br><br>

<table class="ttd" width="100%">

<tr>

<td width="33%">
Orang Tua/Wali Siswa
<br><br><br><br><br><br>
…………………………………….
</td>

<td width="34%">
Guru kelas/<br>
Wali kelas / {{ $siswa->kelas->nama_kelas }}
<br><br><br><br><br>
<b>{{ $siswa->kelas->user->name ?? '................................' }}</b>
</td>

<td width="33%">
Mengetahui<br>
Kepala Sekolah<br>
{{ $pengaturan->nama_sekolah ?? '' }}
<br><br><br><br>
<b>{{ $pengaturan->kepala_sekolah ?? '-' }}</b>
<br>
@if(!empty($pengaturan->nip_kepala))
NIP. {{ $pengaturan->nip_kepala }}
@endif
</td>

</tr>

</table>

</body>

</html>
