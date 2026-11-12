

<?php $__env->startSection('title','Item Kegiatan'); ?>

<?php $__env->startSection('content'); ?>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">Data Item Kegiatan</h5>

        <a href="<?php echo e(route('admin.item.create')); ?>" class="btn btn-success">
            Tambah Item
        </a>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

            <tr>
                <th width="60">No</th>
                <th>Kategori</th>
                <th>Nama Item</th>
                <th width="80">Urutan</th>
                <th width="180">Aksi</th>
            </tr>

            </thead>

            <tbody>

            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr>

                <td><?php echo e($i+1); ?></td>

                <td><?php echo e($d->katagori->nama_katagori); ?></td>

                <td><?php echo e($d->nama_item); ?></td>

                <td><?php echo e($d->urutan); ?></td>

                <td>

                    <a href="<?php echo e(route('admin.item.edit',$d->id_item)); ?>"
                        class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form
                        action="<?php echo e(route('admin.item.destroy',$d->id_item)); ?>"
                        method="POST"
                        class="d-inline">

                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <button
                            onclick="return confirm('Yakin hapus?')"
                            class="btn btn-danger btn-sm">

                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tbody>

        </table>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/admin/item/index.blade.php ENDPATH**/ ?>