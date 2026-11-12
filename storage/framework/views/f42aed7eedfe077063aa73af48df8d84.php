

<?php $__env->startSection('title','Indikator Penilaian'); ?>

<?php $__env->startSection('content'); ?>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Indikator Penilaian</h5>

        <a href="<?php echo e(route('admin.indikator.create')); ?>" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">
            <thead class="table-success">
                <tr>
                    <th width="50">No</th>
                    <th>Aspek</th>
                    <th>Indikator</th>
                    <th width="80">Urutan</th>
                    <th width="170">Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php $__empty_1 = true; $__currentLoopData = $indikator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>

                    <td><?php echo e($loop->iteration); ?></td>

                    <td><?php echo e($item->aspek->nama_aspek); ?></td>

                    <td><?php echo e($item->capaian_pembelajaran); ?></td>

                    <td><?php echo e($item->urutan); ?></td>

                    <td>

                        <a href="<?php echo e(route('admin.indikator.edit',$item->id_indikator)); ?>"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form
                            action="<?php echo e(route('admin.indikator.destroy',$item->id_indikator)); ?>"
                            method="POST"
                            class="d-inline">

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button
                                onclick="return confirm('Hapus indikator ini?')"
                                class="btn btn-danger btn-sm">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada data.
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/admin/indikator/index.blade.php ENDPATH**/ ?>