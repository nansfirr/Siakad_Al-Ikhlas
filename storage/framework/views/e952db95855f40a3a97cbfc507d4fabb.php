

<?php $__env->startSection('content'); ?>

<div class="container mt-3">

    <h4>Aspek Perkembangan</h4>

    <a href="<?php echo e(route('admin.aspek.create')); ?>" class="btn btn-primary btn-sm mb-3">
        + Tambah
    </a>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Aspek</th>
            <th>Urutan</th>
            <th>Aksi</th>
        </tr>

        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($i+1); ?></td>
            <td><?php echo e($d->nama_aspek); ?></td>
            <td><?php echo e($d->urutan); ?></td>
            <td>
                <a href="<?php echo e(route('admin.aspek.edit', $d->id_aspek)); ?>" class="btn btn-warning btn-sm">Edit</a>

                <form action="<?php echo e(route('admin.aspek.destroy', $d->id_aspek)); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </table>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/admin/aspek/index.blade.php ENDPATH**/ ?>