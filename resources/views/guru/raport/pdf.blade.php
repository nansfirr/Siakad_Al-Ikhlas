<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>

Raport {{ $siswa->nama_siswa }}

</title>

<style>

@page{

margin:20px 25px;

}

body{

font-family:DejaVu Sans,sans-serif;

font-size:11px;

color:#000;

line-height:1.5;

}

table{

width:100%;

border-collapse:collapse;

}

td,th{

border:1px solid #000;

padding:5px;

vertical-align:top;

}

.center{

text-align:center;

}

.right{

text-align:right;

}

.bold{

font-weight:bold;

}

.logo{

width:85px;

height:auto;

}

.header{

text-align:center;

margin-bottom:12px;

}

.header h3{

margin:3px;

font-size:18px;

}

.section{

background:#d9ead3;

padding:8px;

border:1px solid #000;

font-weight:bold;

margin-top:12px;

margin-bottom:8px;

}

.info td{

border:none;

padding:3px;

}

.nilai th{

background:#eeeeee;

text-align:center;

}

.deskripsi{

border:1px solid #000;

padding:10px;

min-height:90px;

text-align:justify;

}

.foto{

width:165px;

height:165px;

border:1px solid #000;

object-fit:cover;

}

.foto-kosong{

width:165px;

height:165px;

border:1px solid #000;

}

.cover{

margin-top:90px;

text-align:center;

}

.cover h2{

margin-top:25px;

margin-bottom:10px;

font-size:22px;

}

.cover h3{

margin:5px;

font-size:18px;

}

.page-break{

page-break-after:always;

}

.ttd td{

border:none;

text-align:center;

}

</style>

</head>

<body>

{{-- ===================== --}}
{{-- COVER --}}
{{-- ===================== --}}

<div class="cover">

@if(!empty($pengaturan->logo))

<img
src="{{ public_path('storage/'.$pengaturan->logo) }}"
class="logo">

@endif

<h2>

LAPORAN PENCAPAIAN
PERKEMBANGAN ANAK

</h2>

<h3>

{{ strtoupper($pengaturan->nama_sekolah) }}

</h3>

<br><br><br>

<table
class="info"
style="width:70%;margin:auto;">

<tr>

<td width="35%">

Nama Anak

</td>

<td width="5%">

:

</td>

<td>

<b>

{{ $siswa->nama_siswa }}

</b>

</td>

</tr>

<tr>

<td>

NIS

</td>

<td>

:

</td>

<td>

{{ $siswa->nis }}

</td>

</tr>

<tr>

<td>

Kelompok

</td>

<td>

:

</td>

<td>

{{ $siswa->kelas->nama_kelas }}

</td>

</tr>

<tr>

<td>

Semester

</td>

<td>

:

</td>

<td>

{{ $semester }}

</td>

</tr>

<tr>

<td>

Tahun Ajaran

</td>

<td>

:

</td>

<td>

{{ $tahun_ajaran }}

</td>

</tr>

</table>

</div>

<div class="page-break"></div>
{{-- ========================================= --}}
{{-- PETUNJUK PENILAIAN --}}
{{-- ========================================= --}}

<div class="header">

@if(!empty($pengaturan->logo))
<img src="{{ public_path('storage/'.$pengaturan->logo) }}" class="logo">
@endif

<h3>
LAPORAN PENCAPAIAN PERKEMBANGAN ANAK
</h3>

<strong>
{{ strtoupper($pengaturan->nama_sekolah) }}
</strong>

</div>

<div class="section">

PETUNJUK PENILAIAN

</div>

<table>

<tr style="background:#eeeeee;">

<th width="18%">
Kode
</th>

<th>
Keterangan
</th>

</tr>

<tr>

<td class="center">
BB
</td>

<td>

Belum Berkembang

</td>

</tr>

<tr>

<td class="center">
MB
</td>

<td>

Mulai Berkembang

</td>

</tr>

<tr>

<td class="center">
BSH
</td>

<td>

Berkembang Sesuai Harapan

</td>

</tr>

<tr>

<td class="center">
BSB
</td>

<td>

Berkembang Sangat Baik

</td>

</tr>

</table>

<br>

<table class="info">

<tr>

<td style="border:none;">

Laporan perkembangan anak merupakan hasil pengamatan guru terhadap capaian perkembangan peserta didik selama satu semester. Penilaian dilakukan secara autentik berdasarkan aktivitas belajar anak di sekolah.

</td>

</tr>

</table>

<div class="page-break"></div>

{{-- ========================================= --}}
{{-- ASPEK PERKEMBANGAN --}}
{{-- ========================================= --}}

@foreach($aspek as $a)

@php

$desk = $deskripsi[$a->id_aspek] ?? null;

@endphp

<div class="header">

@if(!empty($pengaturan->logo))
<img src="{{ public_path('storage/'.$pengaturan->logo) }}" class="logo">
@endif

<h3>

LAPORAN PENCAPAIAN PERKEMBANGAN ANAK

</h3>

<strong>

{{ strtoupper($pengaturan->nama_sekolah) }}

</strong>

</div>

<table class="info">

<tr>

<td width="20%">

Nama Anak

</td>

<td width="3%">

:

</td>

<td width="30%">

{{ $siswa->nama_siswa }}

</td>

<td width="20%">

Semester

</td>

<td width="3%">

:

</td>

<td>

{{ $semester }}

</td>

</tr>

<tr>

<td>

Kelompok

</td>

<td>

:

</td>

<td>

{{ $siswa->kelas->nama_kelas }}

</td>

<td>

Tahun Ajaran

</td>

<td>

:

</td>

<td>

{{ $tahun_ajaran }}

</td>

</tr>

</table>

<div class="section">

{{ $a->urutan }}.

{{ strtoupper($a->nama_aspek) }}

</div>

<table class="nilai">

<thead>

<tr>

<th width="6%">

No

</th>

<th>

Capaian Pembelajaran

</th>

<th width="8%">

BB

</th>

<th width="8%">

MB

</th>

<th width="8%">

BSH

</th>

<th width="8%">

BSB

</th>

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

{!! $nilai=='BB' ? '✔' : '' !!}

</td>

<td class="center">

{!! $nilai=='MB' ? '✔' : '' !!}

</td>

<td class="center">

{!! $nilai=='BSH' ? '✔' : '' !!}

</td>

<td class="center">

{!! $nilai=='BSB' ? '✔' : '' !!}

</td>

</tr>

@endforeach

</tbody>

</table>
<br>

<b>Deskripsi Capaian Perkembangan</b>

<div class="deskripsi">

{{ $desk->deskripsi ?? '-' }}

</div>

<br>

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

<br>

<table class="info">

<tr>

<td style="border:none;font-size:10px;">

Dokumentasi kegiatan merupakan bukti hasil belajar anak sesuai
capaian perkembangan pada aspek di atas.

</td>

</tr>

</table>

@if(!$loop->last)

<div class="page-break"></div>

@endif

@endforeach

<div class="page-break"></div>
{{-- ========================================= --}}
{{-- KEGIATAN TAMBAHAN --}}
{{-- ========================================= --}}

<div class="header">

@if(!empty($pengaturan->logo))
<img src="{{ public_path('storage/'.$pengaturan->logo) }}" class="logo">
@endif

<h3>

LAPORAN PENCAPAIAN PERKEMBANGAN ANAK

</h3>

<strong>

{{ strtoupper($pengaturan->nama_sekolah) }}

</strong>

</div>

<div class="section">

KEGIATAN TAMBAHAN

</div>

@foreach($katagori as $kategori)

<table width="100%" style="margin-bottom:8px;">

<tr>

<td style="
background:#eeeeee;
font-weight:bold;
padding:8px;
border:1px solid #000;
">

{{ strtoupper($kategori->nama_katagori) }}

</td>

</tr>

</table>

<table class="nilai">

<thead>

<tr>

<th width="8%">

No

</th>

<th>

Nama Kegiatan

</th>

<th width="20%">

Nilai

</th>

</tr>

</thead>

<tbody>

@php

$no=1;

@endphp

@foreach($kategori->itemKegiatan as $item)

@php

$nilai=$kegiatan
            ->where('id_item',$item->id_item)
            ->first();

@endphp

<tr>

<td class="center">

{{ $no++ }}

</td>

<td>

{{ $item->nama_item }}

</td>

<td class="center">

{{ $nilai->nilai ?? '-' }}

</td>

</tr>

@endforeach

</tbody>

</table>

<br>

@endforeach

<div style="
margin-top:15px;
font-size:10px;
text-align:justify;
">

Kegiatan tambahan merupakan kegiatan yang diikuti peserta didik di luar pembelajaran utama sebagai pendukung pengembangan potensi, minat, bakat, dan pembiasaan karakter.

</div>

<div class="page-break"></div>
{{-- ========================================= --}}
{{-- PRESENSI DAN ANTROPOMETRI --}}
{{-- ========================================= --}}

<div class="header">

@if(!empty($pengaturan->logo))
<img src="{{ public_path('storage/'.$pengaturan->logo) }}" class="logo">
@endif

<h3>

LAPORAN PENCAPAIAN PERKEMBANGAN ANAK

</h3>

<strong>

{{ strtoupper($pengaturan->nama_sekolah) }}

</strong>

</div>

<div class="section">

PRESENSI DAN PERTUMBUHAN ANAK

</div>

<table width="100%">

<tr style="background:#eeeeee;">

<th width="50%">

PRESENSI

</th>

<th width="50%">

ANTROPOMETRI

</th>

</tr>

<tr>

<td>

<table width="100%">

<tr>

<td width="70%">

Sakit

</td>

<td class="center">

{{ $presensi->sakit ?? 0 }} Hari

</td>

</tr>

<tr>

<td>

Izin

</td>

<td class="center">

{{ $presensi->izin ?? 0 }} Hari

</td>

</tr>

<tr>

<td>

Tanpa Keterangan

</td>

<td class="center">

{{ $presensi->alpha ?? 0 }} Hari

</td>

</tr>

</table>

</td>

<td>

<table width="100%">

<tr>

<td width="70%">

Tinggi Badan

</td>

<td class="center">

{{ $antropometri->tinggi_badan ?? '-' }} cm

</td>

</tr>

<tr>

<td>

Berat Badan

</td>

<td class="center">

{{ $antropometri->berat_badan ?? '-' }} kg

</td>

</tr>

<tr>

<td>

Lingkar Kepala

</td>

<td class="center">

{{ $antropometri->lingkar_kepala ?? '-' }} cm

</td>

</tr>

</table>

</td>

</tr>

</table>

<br>

<div style="border:1px solid #000;padding:10px;">

<b>Catatan Perkembangan Fisik</b>

<br><br>

Pertumbuhan fisik anak dipantau melalui pengukuran tinggi badan, berat badan, dan lingkar kepala. Data ini digunakan sebagai salah satu indikator perkembangan anak selama satu semester.

</div>

<br>

<div style="border:1px solid #000;padding:10px;min-height:120px;">

<b>Catatan Guru</b>

<br><br>

........................................................................................

<br><br>

........................................................................................

<br><br>

........................................................................................

</div>

<div class="page-break"></div>
{{-- ========================================= --}}
{{-- REFLEKSI DAN PENGESAHAN --}}
{{-- ========================================= --}}

<div class="header">

@if(!empty($pengaturan->logo))
<img src="{{ public_path('storage/'.$pengaturan->logo) }}" class="logo">
@endif

<h3>

LAPORAN PENCAPAIAN PERKEMBANGAN ANAK

</h3>

<strong>

{{ strtoupper($pengaturan->nama_sekolah) }}

</strong>

</div>

<div class="section">

REFLEKSI DAN PENGESAHAN

</div>

<table width="100%">

<tr style="background:#eeeeee;">

<th>

REFLEKSI GURU

</th>

</tr>

<tr>

<td style="height:140px;vertical-align:top;">

{{ $refleksiGuru->refleksi ?? '-' }}

</td>

</tr>

</table>

<br>

<table width="100%">

<tr style="background:#eeeeee;">

<th>

REFLEKSI ORANG TUA

</th>

</tr>

<tr>

<td style="height:170px;">

&nbsp;

</td>

</tr>

</table>

<br><br>

<table class="ttd" width="100%">

<tr>

<td width="33%">

Mengetahui,

<br>

Orang Tua / Wali

<br><br><br><br><br><br>

(................................)

</td>

<td width="33%">

{{ date('d F Y') }}

<br><br>

Guru Kelas

<br><br><br><br><br><br>

(................................)

</td>

<td width="34%">

Kepala Sekolah

<br><br><br><br><br><br>

<b>

{{ $pengaturan->kepala_sekolah ?? '-' }}

</b>

<br>

@if(!empty($pengaturan->nip_kepala))

NIP.

{{ $pengaturan->nip_kepala }}

@endif

</td>

</tr>

</table>

</body>

</html>