<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi</title>
    <style>
        body { font-family: sans-serif; font-size: 9px; }
        h3, h4 { text-align: center; margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 3px 5px; text-align: center; }
        th { background-color: #c8e6c9; }
        .text-start { text-align: left; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 6px; margin-bottom: 8px; }
    </style>
</head>
<body>
<div class="header">
    <h3>LAPORAN REKAPITULASI PERKEMBANGAN ANAK</h3>
    <h4>TK AL-IKHLAS TALIWANG</h4>
    <p><?php echo e($kelas->nama_kelas); ?> | Semester <?php echo e($semester); ?> | Tahun Ajaran <?php echo e($tahunAjaran); ?></p>
</div>

<table>
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2" class="text-start">Nama Siswa</th>
            <?php $__currentLoopData = $aspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <th><?php echo e($a->nama_aspek); ?></th>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <th colspan="3">Presensi</th>
        </tr>
        <tr>
            <?php $__currentLoopData = $aspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><th>Nilai</th><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <th>H</th><th>I</th><th>TK</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($i+1); ?></td>
            <td class="text-start"><?php echo e($s->nama_siswa); ?></td>
            <?php $__currentLoopData = $aspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <td><?php echo e($rekapNilai[$s->id_siswa][$a->id_aspek] ?? '-'); ?></td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php $p = $rekapPresensi[$s->id_siswa] ?? null; ?>
            <td><?php echo e($p?->hadir ?? '-'); ?></td>
            <td><?php echo e($p?->izin ?? '-'); ?></td>
            <td><?php echo e($p?->tanpa_keterangan ?? '-'); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</body>
</html><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/guru/laporan/pdf.blade.php ENDPATH**/ ?>