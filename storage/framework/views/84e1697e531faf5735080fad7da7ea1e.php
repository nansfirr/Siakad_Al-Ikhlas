

<?php $__env->startSection('title','Tambah Item Kegiatan'); ?>

<?php $__env->startSection('content'); ?>

<div class="card shadow-sm">

<div class="card-header">
Tambah Item Kegiatan
</div>

<div class="card-body">

<form action="<?php echo e(route('admin.item.store')); ?>" method="POST">

<?php echo csrf_field(); ?>

<div class="mb-3">

<label>Kategori</label>

<select name="id_katagori" class="form-control">

<?php $__currentLoopData = $katagori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<option value="<?php echo e($k->id_katagori); ?>">
<?php echo e($k->nama_katagori); ?>

</option>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>

</div>

<div class="mb-3">

<label>Nama Item</label>

<input
type="text"
name="nama_item"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Urutan</label>

<input
type="number"
name="urutan"
class="form-control"
required>

</div>

<button class="btn btn-success">

Simpan

</button>

<a
href="<?php echo e(route('admin.item.index')); ?>"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/admin/item/create.blade.php ENDPATH**/ ?>