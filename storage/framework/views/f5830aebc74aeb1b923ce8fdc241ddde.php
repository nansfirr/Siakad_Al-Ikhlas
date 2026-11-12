
<?php $__env->startSection('title', 'Laporan Presensi'); ?>
<?php $__env->startSection('content'); ?>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Filter Kelas</label>
                <select name="id_kelas" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas --</option>
                    <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k->id_kelas); ?>" <?php echo e($kelasId==$k->id_kelas?'selected':''); ?>>
                            <?php echo e($k->nama_kelas); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold small">Semester</label>
                <select name="semester" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="1" <?php echo e($semester=='1'?'selected':''); ?>>Semester 1</option>
                    <option value="2" <?php echo e($semester=='2'?'selected':''); ?>>Semester 2</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" class="form-control form-control-sm"
                    value="<?php echo e($tahunAjaran); ?>" onchange="this.form.submit()">
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold">
        Laporan Presensi Seluruh Siswa — Semester <?php echo e($semester); ?>

    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm text-center align-middle">
            <thead class="table-success">
                <tr>
                    <th>No</th>
                    <th class="text-start">Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Tanpa Ket.</th>
                    <th>Total Hari</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php $p = $rekapPresensi[$s->id_siswa] ?? null; ?>
                <tr>
                    <td><?php echo e($i+1); ?></td>
                    <td class="text-start"><?php echo e($s->nama_siswa); ?></td>
                    <td><?php echo e($s->kelas->nama_kelas ?? '-'); ?></td>
                    <td><span class="badge bg-success"><?php echo e($p?->hadir ?? 0); ?></span></td>
                    <td><span class="badge bg-warning text-dark"><?php echo e($p?->izin ?? 0); ?></span></td>
                    <td><span class="badge bg-danger"><?php echo e($p?->tanpa_keterangan ?? 0); ?></span></td>
                    <td><?php echo e(($p?->hadir ?? 0) + ($p?->izin ?? 0) + ($p?->tanpa_keterangan ?? 0)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-muted">Belum ada data presensi.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/kepsek/laporan/presensi.blade.php ENDPATH**/ ?>