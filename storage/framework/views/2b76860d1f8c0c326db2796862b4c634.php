
<?php $__env->startSection('title', 'Input Antropometri'); ?>
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
                            <?php echo e($k->nama_kelas); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold small">Semester</label>
                <select name="semester" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="1" <?php echo e($semester == '1' ? 'selected' : ''); ?>>Semester 1</option>
                    <option value="2" <?php echo e($semester == '2' ? 'selected' : ''); ?>>Semester 2</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" class="form-control form-control-sm"
                    value="<?php echo e($tahunAjaran); ?>" placeholder="2025/2026" onchange="this.form.submit()">
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0">Data Antropometri Siswa</h6>
    </div>
    <div class="card-body">
        <?php if($siswa->isEmpty()): ?>
            <p class="text-muted text-center">Belum ada siswa di kelas ini.</p>
        <?php else: ?>
        <form action="<?php echo e(route('guru.antropometri.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id_kelas" value="<?php echo e($kelasId); ?>">
            <input type="hidden" name="semester" value="<?php echo e($semester); ?>">
            <input type="hidden" name="tahun_ajaran" value="<?php echo e($tahunAjaran); ?>">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Tinggi Badan (cm)</th>
                            <th>Berat Badan (kg)</th>
                            <th>Lingkar Kepala (cm)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $ant = $antropometriData[$s->id_siswa] ?? null; ?>
                        <tr>
                            <td><?php echo e($i + 1); ?></td>
                            <td><?php echo e($s->nama_siswa); ?></td>
                            <td>
                                <input type="number" step="0.1"
                                    name="antropometri[<?php echo e($s->id_siswa); ?>][tinggi_badan]"
                                    class="form-control form-control-sm"
                                    value="<?php echo e($ant?->tinggi_badan); ?>"
                                    style="width:100px">
                            </td>
                            <td>
                                <input type="number" step="0.1"
                                    name="antropometri[<?php echo e($s->id_siswa); ?>][berat_badan]"
                                    class="form-control form-control-sm"
                                    value="<?php echo e($ant?->berat_badan); ?>"
                                    style="width:100px">
                            </td>
                            <td>
                                <input type="number" step="0.1"
                                    name="antropometri[<?php echo e($s->id_siswa); ?>][lingkar_kepala]"
                                    class="form-control form-control-sm"
                                    value="<?php echo e($ant?->lingkar_kepala); ?>"
                                    style="width:100px">
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-success mt-2">
                <i class="bi bi-save"></i> Simpan Antropometri
            </button>
        </form>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/guru/antropometri/index.blade.php ENDPATH**/ ?>