

<?php $__env->startSection('content'); ?>

<div class="container mt-3">

    <h4>Tambah Aspek</h4>

    <form method="POST" action="<?php echo e(route('admin.aspek.store')); ?>">
        <?php echo csrf_field(); ?>

        <div class="mb-2">
            <label>Nama Aspek</label>
            <input type="text" name="nama_aspek" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Urutan</label>
            <input type="number" name="urutan" class="form-control" required>
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/admin/aspek/create.blade.php ENDPATH**/ ?>