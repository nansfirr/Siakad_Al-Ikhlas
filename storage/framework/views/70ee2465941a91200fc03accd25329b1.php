

<?php $__env->startSection('title','Kategori Kegiatan'); ?>

<?php $__env->startSection('content'); ?>

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Kategori Kegiatan</h5>

        <a href="<?php echo e(route('admin.katagori.create')); ?>" class="btn btn-success">
            <i class="bi bi-plus-circle"></i>
            Tambah
        </a>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead class="table-success">
            <tr>
                <th width="70">No</th>
                <th>Nama Kategori</th>
                <th width="100">Urutan</th>
                <th width="170">Aksi</th>
            </tr>
            </thead>

            <tbody>

            <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>

                    <td><?php echo e($i+1); ?></td>

                    <td><?php echo e($d->nama_katagori); ?></td>

                    <td><?php echo e($d->urutan); ?></td>

                    <td>

                        <a href="<?php echo e(route('admin.katagori.edit',$d->id_katagori)); ?>"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form
                            action="<?php echo e(route('admin.katagori.destroy',$d->id_katagori)); ?>"
                            method="POST"
                            style="display:inline">

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus data ini?')">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>
                    <td colspan="4" class="text-center">
                        Belum ada data.
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/admin/katagori/index.blade.php ENDPATH**/ ?>