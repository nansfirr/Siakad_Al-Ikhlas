

<?php $__env->startSection('title','Preview Raport'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">

    <h3 class="mb-0">
        Preview Raport
    </h3>

    <div>

        <a href="<?php echo e(route('guru.raport.index')); ?>"
           class="btn btn-secondary">

            Kembali

        </a>

        <a href="<?php echo e(route('guru.raport.pdf',$siswa->id_siswa)); ?>"
           class="btn btn-success">

            Cetak PDF

        </a>

    </div>

</div>

<iframe
    src="<?php echo e(route('guru.raport.pdf',$siswa->id_siswa)); ?>"
    width="100%"
    height="900"
    style="border:1px solid #ddd;border-radius:8px;">
</iframe>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/guru/raport/show.blade.php ENDPATH**/ ?>