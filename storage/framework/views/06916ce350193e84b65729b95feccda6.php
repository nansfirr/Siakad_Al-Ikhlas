<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>

Raport <?php echo e($siswa->nama_siswa); ?>


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





<div class="cover">

<?php if(!empty($pengaturan->logo)): ?>

<img
src="<?php echo e(public_path('storage/'.$pengaturan->logo)); ?>"
class="logo">

<?php endif; ?>

<h2>

LAPORAN PENCAPAIAN
PERKEMBANGAN ANAK

</h2>

<h3>

<?php echo e(strtoupper($pengaturan->nama_sekolah)); ?>


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

<?php echo e($siswa->nama_siswa); ?>


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

<?php echo e($siswa->nis); ?>


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

<?php echo e($siswa->kelas->nama_kelas); ?>


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

<?php echo e($semester); ?>


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

<?php echo e($tahun_ajaran); ?>


</td>

</tr>

</table>

</div>

<div class="page-break"></div>




<div class="header">

<?php if(!empty($pengaturan->logo)): ?>
<img src="<?php echo e(public_path('storage/'.$pengaturan->logo)); ?>" class="logo">
<?php endif; ?>

<h3>
LAPORAN PENCAPAIAN PERKEMBANGAN ANAK
</h3>

<strong>
<?php echo e(strtoupper($pengaturan->nama_sekolah)); ?>

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





<?php $__currentLoopData = $aspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php

$desk = $deskripsi[$a->id_aspek] ?? null;

?>

<div class="header">

<?php if(!empty($pengaturan->logo)): ?>
<img src="<?php echo e(public_path('storage/'.$pengaturan->logo)); ?>" class="logo">
<?php endif; ?>

<h3>

LAPORAN PENCAPAIAN PERKEMBANGAN ANAK

</h3>

<strong>

<?php echo e(strtoupper($pengaturan->nama_sekolah)); ?>


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

<?php echo e($siswa->nama_siswa); ?>


</td>

<td width="20%">

Semester

</td>

<td width="3%">

:

</td>

<td>

<?php echo e($semester); ?>


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

<?php echo e($siswa->kelas->nama_kelas); ?>


</td>

<td>

Tahun Ajaran

</td>

<td>

:

</td>

<td>

<?php echo e($tahun_ajaran); ?>


</td>

</tr>

</table>

<div class="section">

<?php echo e($a->urutan); ?>.

<?php echo e(strtoupper($a->nama_aspek)); ?>


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

<?php $__currentLoopData = $a->indikatorPenilaian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indikator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php

$nilai = $penilaian[$indikator->id_indikator][0]->nilai ?? '';

?>

<tr>

<td class="center">

<?php echo e($indikator->urutan); ?>


</td>

<td>

<?php echo e($indikator->capaian_pembelajaran); ?>


</td>

<td class="center">

<?php echo $nilai=='BB' ? '✔' : ''; ?>


</td>

<td class="center">

<?php echo $nilai=='MB' ? '✔' : ''; ?>


</td>

<td class="center">

<?php echo $nilai=='BSH' ? '✔' : ''; ?>


</td>

<td class="center">

<?php echo $nilai=='BSB' ? '✔' : ''; ?>


</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</tbody>

</table>
<br>

<b>Deskripsi Capaian Perkembangan</b>

<div class="deskripsi">

<?php echo e($desk->deskripsi ?? '-'); ?>


</div>

<br>

<table style="border:none;">

<tr>

<td style="border:none;width:33%;text-align:center;">

<?php if(!empty($desk->foto1)): ?>

<img
src="<?php echo e(public_path('storage/'.$desk->foto1)); ?>"
class="foto">

<?php else: ?>

<div class="foto-kosong"></div>

<?php endif; ?>

</td>

<td style="border:none;width:33%;text-align:center;">

<?php if(!empty($desk->foto2)): ?>

<img
src="<?php echo e(public_path('storage/'.$desk->foto2)); ?>"
class="foto">

<?php else: ?>

<div class="foto-kosong"></div>

<?php endif; ?>

</td>

<td style="border:none;width:33%;text-align:center;">

<?php if(!empty($desk->foto3)): ?>

<img
src="<?php echo e(public_path('storage/'.$desk->foto3)); ?>"
class="foto">

<?php else: ?>

<div class="foto-kosong"></div>

<?php endif; ?>

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

<?php if(!$loop->last): ?>

<div class="page-break"></div>

<?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<div class="page-break"></div>




<div class="header">

<?php if(!empty($pengaturan->logo)): ?>
<img src="<?php echo e(public_path('storage/'.$pengaturan->logo)); ?>" class="logo">
<?php endif; ?>

<h3>

LAPORAN PENCAPAIAN PERKEMBANGAN ANAK

</h3>

<strong>

<?php echo e(strtoupper($pengaturan->nama_sekolah)); ?>


</strong>

</div>

<div class="section">

KEGIATAN TAMBAHAN

</div>

<?php $__currentLoopData = $katagori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<table width="100%" style="margin-bottom:8px;">

<tr>

<td style="
background:#eeeeee;
font-weight:bold;
padding:8px;
border:1px solid #000;
">

<?php echo e(strtoupper($kategori->nama_katagori)); ?>


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

<?php

$no=1;

?>

<?php $__currentLoopData = $kategori->itemKegiatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php

$nilai=$kegiatan
            ->where('id_item',$item->id_item)
            ->first();

?>

<tr>

<td class="center">

<?php echo e($no++); ?>


</td>

<td>

<?php echo e($item->nama_item); ?>


</td>

<td class="center">

<?php echo e($nilai->nilai ?? '-'); ?>


</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</tbody>

</table>

<br>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<div style="
margin-top:15px;
font-size:10px;
text-align:justify;
">

Kegiatan tambahan merupakan kegiatan yang diikuti peserta didik di luar pembelajaran utama sebagai pendukung pengembangan potensi, minat, bakat, dan pembiasaan karakter.

</div>

<div class="page-break"></div>




<div class="header">

<?php if(!empty($pengaturan->logo)): ?>
<img src="<?php echo e(public_path('storage/'.$pengaturan->logo)); ?>" class="logo">
<?php endif; ?>

<h3>

LAPORAN PENCAPAIAN PERKEMBANGAN ANAK

</h3>

<strong>

<?php echo e(strtoupper($pengaturan->nama_sekolah)); ?>


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

<?php echo e($presensi->sakit ?? 0); ?> Hari

</td>

</tr>

<tr>

<td>

Izin

</td>

<td class="center">

<?php echo e($presensi->izin ?? 0); ?> Hari

</td>

</tr>

<tr>

<td>

Tanpa Keterangan

</td>

<td class="center">

<?php echo e($presensi->alpha ?? 0); ?> Hari

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

<?php echo e($antropometri->tinggi_badan ?? '-'); ?> cm

</td>

</tr>

<tr>

<td>

Berat Badan

</td>

<td class="center">

<?php echo e($antropometri->berat_badan ?? '-'); ?> kg

</td>

</tr>

<tr>

<td>

Lingkar Kepala

</td>

<td class="center">

<?php echo e($antropometri->lingkar_kepala ?? '-'); ?> cm

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




<div class="header">

<?php if(!empty($pengaturan->logo)): ?>
<img src="<?php echo e(public_path('storage/'.$pengaturan->logo)); ?>" class="logo">
<?php endif; ?>

<h3>

LAPORAN PENCAPAIAN PERKEMBANGAN ANAK

</h3>

<strong>

<?php echo e(strtoupper($pengaturan->nama_sekolah)); ?>


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

<?php echo e($refleksiGuru->refleksi ?? '-'); ?>


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

<?php echo e(date('d F Y')); ?>


<br><br>

Guru Kelas

<br><br><br><br><br><br>

(................................)

</td>

<td width="34%">

Kepala Sekolah

<br><br><br><br><br><br>

<b>

<?php echo e($pengaturan->kepala_sekolah ?? '-'); ?>


</b>

<br>

<?php if(!empty($pengaturan->nip_kepala)): ?>

NIP.

<?php echo e($pengaturan->nip_kepala); ?>


<?php endif; ?>

</td>

</tr>

</table>

</body>

</html><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/guru/raport/pdf.blade.php ENDPATH**/ ?>