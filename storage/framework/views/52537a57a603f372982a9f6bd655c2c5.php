

<?php $__env->startSection('title','Tambah Indikator Penilaian'); ?>

<?php $__env->startSection('content'); ?>

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">Tambah Indikator Penilaian</h5>
    </div>

    <div class="card-body">

        <form action="<?php echo e(route('admin.indikator.store')); ?>" method="POST">

            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <label class="form-label">Aspek Perkembangan</label>

                <select name="id_aspek" class="form-select" required>

                    <option value="">-- Pilih Aspek --</option>

                    <?php $__currentLoopData = $aspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($a->id_aspek); ?>">
                            <?php echo e($a->nama_aspek); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">Capaian Pembelajaran</label>

                <textarea
                    name="capaian_pembelajaran"
                    rows="4"
                    class="form-control"
                    required><?php echo e(old('capaian_pembelajaran')); ?></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">Urutan</label>

                <input
                    type="number"
                    name="urutan"
                    class="form-control"
                    value="<?php echo e(old('urutan')); ?>"
                    required>

            </div>

            <button class="btn btn-success">
                Simpan
            </button>

            <a href="<?php echo e(route('admin.indikator.index')); ?>" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/admin/indikator/create.blade.php ENDPATH**/ ?>