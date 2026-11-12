

<?php $__env->startSection('title','Tambah Kategori'); ?>

<?php $__env->startSection('content'); ?>

<div class="card shadow-sm">

<div class="card-header">

Tambah Kategori Kegiatan

</div>

<div class="card-body">

<form action="<?php echo e(route('admin.katagori.store')); ?>" method="POST">

<?php echo csrf_field(); ?>

<div class="mb-3">

<label class="form-label">

Nama Kategori

</label>

<input
type="text"
name="nama_katagori"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Urutan

</label>

<input
type="number"
name="urutan"
class="form-control"
required>

</div>

<button class="btn btn-success">

Simpan

</button>

<a href="<?php echo e(route('admin.katagori.index')); ?>"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/admin/katagori/create.blade.php ENDPATH**/ ?>