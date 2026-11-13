

<?php $__env->startSection('title','Raport'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('error')): ?>

<div class="alert alert-danger">
    <?php echo nl2br(e(session('error'))); ?>

</div>

<?php endif; ?>

<?php if(session('success')): ?>

<div class="alert alert-success">
    <?php echo e(session('success')); ?>

</div>

<?php endif; ?>

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">
            Raport Siswa
        </h4>

        <form method="GET">

            <select
                name="id_kelas"
                class="form-select"
                onchange="this.form.submit()">

                <?php $__currentLoopData = $kelasSaya; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <option
                        value="<?php echo e($kelas->id_kelas); ?>"
                        <?php echo e($kelasId==$kelas->id_kelas ? 'selected' : ''); ?>>

                        <?php echo e($kelas->nama_kelas); ?>


                    </option>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </select>

        </form>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped align-middle">

            <thead class="table-success">

                <tr>

                    <th width="5%">No</th>

                    <th>Nama Siswa</th>

                    <th width="18%">Status</th>

                    <th width="32%">Aksi</th>

                </tr>

            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>

                    <td class="text-center">
                        <?php echo e($loop->iteration); ?>

                    </td>

                    <td>

                        <strong><?php echo e($item->nama_siswa); ?></strong>

                    </td>

                    <td class="text-center">

                        <?php if($item->statusRaport): ?>

                            <span class="badge bg-success">

                                Lengkap

                            </span>

                        <?php else: ?>

                            <span class="badge bg-danger">

                                Belum Lengkap

                            </span>

                        <?php endif; ?>

                    </td>

                    <td>

                        <a
                            href="<?php echo e(route('guru.raport.show',$item->id_siswa)); ?>"
                            class="btn btn-primary btn-sm">

                            👁 Preview

                        </a>

                        <?php if($item->statusRaport): ?>

                            <a
                                href="<?php echo e(route('guru.raport.pdf',$item->id_siswa)); ?>"
                                class="btn btn-success btn-sm">

                                📄 Cetak PDF

                            </a>

                        <?php else: ?>

                            <button
                                class="btn btn-secondary btn-sm"
                                disabled>

                                Lengkapi Data

                            </button>

                        <?php endif; ?>

                    </td>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>

                    <td colspan="4" class="text-center">

                        Belum ada siswa.

                    </td>

                </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projects\siakad-tk-alikhlas\resources\views/guru/raport/index.blade.php ENDPATH**/ ?>