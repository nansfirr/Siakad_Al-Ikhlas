
<?php $__env->startSection('title', 'Laporan Rekapitulasi'); ?>
<?php $__env->startSection('content'); ?>


<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Pilih Kelas</label>
                <select name="id_kelas" class="form-select form-select-sm" onchange="this.form.submit()">
                    <?php $__currentLoopData = $kelasSaya; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k->id_kelas); ?>"
                            <?php echo e($kelasId == $k->id_kelas ? 'selected' : ''); ?>>
                            <?php echo e($k->nama_kelas); ?> (<?php echo e($k->tahun_ajaran); ?>)
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
            <div class="col-md-2">
                <a href="<?php echo e(route('guru.laporan.exportPdf', ['id_kelas'=>$kelasId,'semester'=>$semester,'tahun_ajaran'=>$tahunAjaran])); ?>"
                    class="btn btn-danger btn-sm w-100">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </div>
        </form>
    </div>
</div>


<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0">
            Rekapitulasi Penilaian — <?php echo e($kelas->nama_kelas ?? '-'); ?>

            | Semester <?php echo e($semester); ?> | TA <?php echo e($tahunAjaran); ?>

        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center">
                <thead class="table-success">
                    <tr>
                        <th rowspan="2" class="align-middle">No</th>
                        <th rowspan="2" class="align-middle text-start">Nama Siswa</th>
                        <?php $__currentLoopData = $aspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th colspan="1"><?php echo e($a->nama_aspek); ?></th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <th colspan="3">Presensi</th>
                    </tr>
                    <tr>
                        <?php $__currentLoopData = $aspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th class="small">Nilai</th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <th class="small">H</th>
                        <th class="small">I</th>
                        <th class="small">TK</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($i+1); ?></td>
                        <td class="text-start"><?php echo e($s->nama_siswa); ?></td>
                        <?php $__currentLoopData = $aspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $nilai = $rekapNilai[$s->id_siswa][$a->id_aspek] ?? '-'; ?>
                        <td>
                            <span class="badge
                                <?php echo e($nilai=='BSB' ? 'bg-success' :
                                   ($nilai=='BSH' ? 'bg-primary' :
                                   ($nilai=='MB'  ? 'bg-warning text-dark' :
                                   ($nilai=='BB'  ? 'bg-danger' : 'bg-secondary')))); ?>">
                                <?php echo e($nilai); ?>

                            </span>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php $p = $rekapPresensi[$s->id_siswa] ?? null; ?>
                        <td><?php echo e($p?->hadir ?? '-'); ?></td>
                        <td><?php echo e($p?->izin ?? '-'); ?></td>
                        <td><?php echo e($p?->tanpa_keterangan ?? '-'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="<?php echo e($aspek->count() + 5); ?>" class="text-muted">
                            Belum ada data.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <small class="text-muted">
            H = Hadir | I = Izin | TK = Tanpa Keterangan |
            BSB = Berkembang Sangat Baik | BSH = Berkembang Sesuai Harapan |
            MB = Mulai Berkembang | BB = Belum Berkembang
        </small>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/guru/laporan/index.blade.php ENDPATH**/ ?>