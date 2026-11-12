
<?php $__env->startSection('title', 'Data Siswa'); ?>
<?php $__env->startSection('content'); ?>
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Data Siswa</h6>
        <a href="<?php echo e(route('admin.siswa.create')); ?>" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Siswa
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Jenis Kelamin</th>
                    <th>Nama Wali</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($i + 1); ?></td>
                    <td>
                        <?php if($s->foto): ?>
                            <img src="<?php echo e(asset('storage/'.$s->foto)); ?>"
                                class="rounded-circle" width="40" height="40"
                                style="object-fit:cover">
                        <?php else: ?>
                            <div class="bg-secondary rounded-circle d-flex align-items-center
                                justify-content-center text-white" style="width:40px;height:40px">
                                <i class="bi bi-person"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($s->nis); ?></td>
                    <td><?php echo e($s->nama_siswa); ?></td>
                    <td><?php echo e($s->kelas->nama_kelas ?? '-'); ?></td>
                    <td><?php echo e($s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'); ?></td>
                    <td><?php echo e($s->nama_wali); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.siswa.edit', $s->id_siswa)); ?>"
                            class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="<?php echo e(route('admin.siswa.destroy', $s->id_siswa)); ?>"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin hapus siswa ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada data siswa.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/admin/siswa/index.blade.php ENDPATH**/ ?>