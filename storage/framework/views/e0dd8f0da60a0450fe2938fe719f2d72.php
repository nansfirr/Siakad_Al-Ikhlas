

<?php $__env->startSection('content'); ?>

<div class="container mt-3">

    <h4>Edit Aspek</h4>

    <form method="POST" action="<?php echo e(route('admin.aspek.update', $data->id_aspek)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-2">
            <label>Nama Aspek</label>
            <input type="text" name="nama_aspek" class="form-control" value="<?php echo e($data->nama_aspek); ?>" required>
        </div>

        <div class="mb-2">
            <label>Urutan</label>
            <input type="number" name="urutan" class="form-control" value="<?php echo e($data->urutan); ?>" required>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/admin/aspek/edit.blade.php ENDPATH**/ ?>