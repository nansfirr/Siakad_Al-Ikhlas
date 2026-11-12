
<?php $__env->startSection('title', 'Penilaian Kegiatan — '.$siswa->nama_siswa); ?>
<?php $__env->startSection('content'); ?>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h6 class="fw-bold mb-0"><?php echo e($siswa->nama_siswa); ?></h6>
            <small class="text-muted">NIS: <?php echo e($siswa->nis); ?> | Semester <?php echo e($semester); ?></small>
        </div>
        <a href="<?php echo e(route('guru.kegiatan.index')); ?>" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?php echo e(route('guru.kegiatan.store', $siswa->id_siswa)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="semester" value="<?php echo e($semester); ?>">
    <input type="hidden" name="tahun_ajaran" value="<?php echo e($tahunAjaran); ?>">

    <?php $__currentLoopData = $katagori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-success text-white">
            <h6 class="mb-0"><?php echo e($kat->urutan); ?>. <?php echo e($kat->nama_katagori); ?></h6>
        </div>
        <div class="card-body">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Item Penilaian</th>
                        <th class="text-center">BB</th>
                        <th class="text-center">MB</th>
                        <th class="text-center">BSH</th>
                        <th class="text-center">BSB</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $kat->itemKegiatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $existing = $nilaiExisting[$item->id_item] ?? null; ?>
                    <tr>
                        <td><?php echo e($item->urutan); ?></td>
                        <td><?php echo e($item->nama_item); ?></td>
                        <?php $__currentLoopData = ['BB','MB','BSH','BSB']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nilai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td class="text-center">
                            <input type="radio"
                                name="nilai[<?php echo e($item->id_item); ?>][nilai]"
                                value="<?php echo e($nilai); ?>"
                                class="form-check-input"
                                <?php echo e(($existing?->nilai ?? '') == $nilai ? 'checked' : ''); ?>

                                required>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="d-flex gap-2 mb-4">
        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Simpan Penilaian Kegiatan
        </button>
        <a href="<?php echo e(route('guru.kegiatan.index')); ?>" class="btn btn-secondary">Batal</a>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/guru/kegiatan/show.blade.php ENDPATH**/ ?>