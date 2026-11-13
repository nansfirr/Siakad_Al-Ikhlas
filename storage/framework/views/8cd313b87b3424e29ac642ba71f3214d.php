
<?php $__env->startSection('title', 'Refleksi Guru'); ?>
<?php $__env->startSection('content'); ?>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Pilih Kelas</label>
                <select name="id_kelas" class="form-select form-select-sm" onchange="this.form.submit()">
                    <?php $__currentLoopData = $kelasSaya; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k->id_kelas); ?>" <?php echo e($kelasId == $k->id_kelas ? 'selected' : ''); ?>>
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
                       value="<?php echo e($tahunAjaran); ?>" onchange="this.form.submit()">
            </div>
        </form>
    </div>
</div>

<form action="<?php echo e(route('guru.refleksi.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="id_kelas" value="<?php echo e($kelasId); ?>">
    <input type="hidden" name="semester" value="<?php echo e($semester); ?>">
    <input type="hidden" name="tahun_ajaran" value="<?php echo e($tahunAjaran); ?>">

    <?php $__empty_1 = true; $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php $ref = $refleksiData[$s->id_siswa] ?? null; ?>
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <label class="form-label fw-bold text-success">
                    <?php echo e($i + 1); ?>. <?php echo e($s->nama_siswa); ?> 
                    <span class="text-muted fw-normal">| NIS: <?php echo e($s->nis); ?></span>
                </label>
                <textarea name="refleksi[<?php echo e($s->id_siswa); ?>][catatan_guru]" 
                          class="form-control" rows="3" required
                          placeholder="Tuliskan catatan perkembangan dan refleksi untuk <?php echo e($s->nama_siswa); ?>..."><?php echo e(old('refleksi.'.$s->id_siswa.'.catatan_guru', $ref?->catatan_guru)); ?></textarea>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-muted text-center">Belum ada siswa di kelas ini.</p>
    <?php endif; ?>

    <?php if($siswa->isNotEmpty()): ?>
        <button type="submit" class="btn btn-success mb-4">
            <i class="bi bi-save"></i> Simpan Semua Refleksi
        </button>
    <?php endif; ?>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projects\siakad-tk-alikhlas\resources\views/guru/refleksi/index.blade.php ENDPATH**/ ?>