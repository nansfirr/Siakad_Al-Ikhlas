
<?php $__env->startSection('title', 'Penilaian 6 Aspek'); ?>
<?php $__env->startSection('content'); ?>


<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
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
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Semester</label>
                <select name="semester" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="1" <?php echo e($semester == '1' ? 'selected' : ''); ?>>Semester 1</option>
                    <option value="2" <?php echo e($semester == '2' ? 'selected' : ''); ?>>Semester 2</option>
                </select>
            </div>
        </form>
    </div>
</div>


<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0">Daftar Siswa — Semester <?php echo e($semester); ?></h6>
    </div>
    <div class="card-body">
        <?php if($siswa->isEmpty()): ?>
            <p class="text-muted text-center">Belum ada siswa di kelas ini.</p>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Status Penilaian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $jumlahNilai = $s->penilaian->where('semester', $semester)->count();
                    ?>
                    <tr>
                        <td><?php echo e($i + 1); ?></td>
                        <td><?php echo e($s->nama_siswa); ?></td>
                        <td>
                            <?php if($jumlahNilai > 0): ?>
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Sudah Dinilai (<?php echo e($jumlahNilai); ?> indikator)
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Belum Dinilai</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('guru.penilaian.show', [$s->id_siswa, 'semester' => $semester])); ?>"
                                class="btn btn-success btn-sm">
                                <i class="bi bi-pencil-square"></i>
                                <?php echo e($jumlahNilai > 0 ? 'Edit Penilaian' : 'Input Penilaian'); ?>

                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projects\siakad-tk-alikhlas\resources\views/guru/penilaian/index.blade.php ENDPATH**/ ?>