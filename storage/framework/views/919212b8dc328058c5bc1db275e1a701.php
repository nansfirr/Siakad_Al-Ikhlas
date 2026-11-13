
<?php $__env->startSection('title', 'Data Pengguna'); ?>
<?php $__env->startSection('content'); ?>
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Data Pengguna</h6>
        <a href="<?php echo e(route('admin.pengguna.create')); ?>" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Pengguna
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pengguna; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($i + 1); ?></td>
                    <td><?php echo e($p->name); ?></td>
                    <td><?php echo e($p->email); ?></td>
                    <td>
                        <span class="badge <?php echo e($p->role == 'guru' ? 'bg-primary' : 'bg-info'); ?>">
                            <?php echo e(ucfirst($p->role)); ?>

                        </span>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.pengguna.edit', $p->id)); ?>"
                            class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="<?php echo e(route('admin.pengguna.destroy', $p->id)); ?>"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin hapus pengguna ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data pengguna.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projects\siakad-tk-alikhlas\resources\views/admin/pengguna/index.blade.php ENDPATH**/ ?>