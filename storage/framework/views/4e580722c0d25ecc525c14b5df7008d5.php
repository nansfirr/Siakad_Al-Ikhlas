
<?php $__env->startSection('title', 'Dashboard Guru'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    
    <div class="mb-4">
        <h3 class="fw-bold mb-1">
            <i class="bi bi-mortarboard-fill text-success"></i>
            Dashboard Guru
        </h3>
        <p class="text-muted mb-0">
            Selamat datang,
            <strong><?php echo e(Auth::user()->name); ?></strong>.
            Semoga aktivitas mengajar hari ini berjalan lancar.
        </p>
    </div>

    
    <div class="row g-3 mb-4">

        <div class="col-md-6">
            <div class="card border-0 shadow-sm text-white bg-success">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-2 fw-bold">
                            <?php echo e($kelas->count()); ?>

                        </div>
                        <div>Kelas Saya</div>
                    </div>

                    <i class="bi bi-door-open fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm text-white bg-primary">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-2 fw-bold">
                            <?php echo e($total_siswa); ?>

                        </div>
                        <div>Total Siswa</div>
                    </div>

                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        
        <div class="col-lg-7 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-journal-text me-2"></i>
                        Daftar Kelas Saya
                    </h5>
                </div>

                <div class="card-body">

                    <?php $__empty_1 = true; $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                            <div>

                                <h6 class="mb-1 fw-bold">
                                    <?php echo e($k->nama_kelas); ?>

                                </h6>

                                <small class="text-muted">
                                    Tahun Ajaran <?php echo e($k->tahun_ajaran); ?>

                                </small>

                            </div>

                            <span class="badge bg-success rounded-pill px-3 py-2">
                                <?php echo e($k->siswa->count()); ?> Siswa
                            </span>

                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <div class="text-center py-4">

                            <i class="bi bi-folder-x fs-1 text-secondary"></i>

                            <p class="text-muted mt-2 mb-0">
                                Belum ada kelas yang ditugaskan.
                            </p>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

        
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Informasi Sistem
                    </h5>
                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>
                            <td>Tahun Ajaran</td>
                            <td class="fw-semibold">2025/2026</td>
                        </tr>

                        <tr>
                            <td>Semester</td>
                            <td class="fw-semibold">1</td>
                        </tr>

                        <tr>
                            <td>Total Kelas</td>
                            <td class="fw-semibold">
                                <?php echo e($kelas->count()); ?>

                            </td>
                        </tr>

                        <tr>
                            <td>Total Siswa</td>
                            <td class="fw-semibold">
                                <?php echo e($total_siswa); ?>

                            </td>
                        </tr>

                    </table>

                    <hr>

                    <h6 class="fw-bold">
                        Aktivitas Guru
                    </h6>

                    <ul class="mb-0">

                        <li>Input Penilaian</li>

                        <li>Input Presensi</li>

                        <li>Cetak Rapor</li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projects\siakad-tk-alikhlas\resources\views/guru/dashboard.blade.php ENDPATH**/ ?>