
<?php $__env->startSection('title','Dashboard Kepala Sekolah'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    
    <div class="mb-4">
        <h3 class="fw-bold mb-1">
            <i class="bi bi-person-workspace text-primary"></i>
            Dashboard Kepala Sekolah
        </h3>

        <p class="text-muted mb-0">
            Selamat datang,
            <strong><?php echo e(Auth::user()->name); ?></strong>.
            Berikut ringkasan data akademik TK Al-Ikhlas.
        </p>
    </div>

    
    <div class="row g-3 mb-4">

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <h2 class="fw-bold mb-0">
                            <?php echo e($data['total_siswa']); ?>

                        </h2>
                        <small>Total Siswa</small>
                    </div>

                    <i class="bi bi-people-fill fs-1 opacity-50"></i>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <h2 class="fw-bold mb-0">
                            <?php echo e($data['total_kelas']); ?>

                        </h2>
                        <small>Total Kelas</small>
                    </div>

                    <i class="bi bi-door-open-fill fs-1 opacity-50"></i>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-warning text-dark">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <h2 class="fw-bold mb-0">
                            <?php echo e($data['total_guru']); ?>

                        </h2>
                        <small>Total Guru</small>
                    </div>

                    <i class="bi bi-person-badge-fill fs-1 opacity-50"></i>

                </div>
            </div>
        </div>

    </div>

    <div class="row">

        
        <div class="col-lg-8 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-bar-chart-line me-2"></i>
                        Distribusi Nilai Per Aspek
                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover text-center align-middle">

                            <thead class="table-success">

                            <tr>

                                <th class="text-start">
                                    Aspek Perkembangan
                                </th>

                                <th>BB</th>
                                <th>MB</th>
                                <th>BSH</th>
                                <th>BSB</th>

                            </tr>

                            </thead>

                            <tbody>

                            <?php $__currentLoopData = $aspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>

                                <td class="text-start fw-semibold">
                                    <?php echo e($a->nama_aspek); ?>

                                </td>

                                <?php $__currentLoopData = ['BB','MB','BSH','BSB']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <td>

                                    <span class="badge
                                        <?php echo e($n=='BSB' ? 'bg-success'
                                        : ($n=='BSH' ? 'bg-primary'
                                        : ($n=='MB' ? 'bg-warning text-dark'
                                        : 'bg-danger'))); ?>">

                                        <?php echo e($grafik[$a->nama_aspek][$n] ?? 0); ?>


                                    </span>

                                </td>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        
        <div class="col-lg-4 mb-4">

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
                            <td>Total Siswa</td>
                            <td class="fw-bold"><?php echo e($data['total_siswa']); ?></td>
                        </tr>

                        <tr>
                            <td>Total Guru</td>
                            <td class="fw-bold"><?php echo e($data['total_guru']); ?></td>
                        </tr>

                        <tr>
                            <td>Total Kelas</td>
                            <td class="fw-bold"><?php echo e($data['total_kelas']); ?></td>
                        </tr>

                        <tr>
                            <td>Jumlah Aspek</td>
                            <td class="fw-bold"><?php echo e($aspek->count()); ?></td>
                        </tr>

                    </table>

                    <hr>

                    <div class="small text-muted">

                        Kepala sekolah dapat memonitor perkembangan peserta didik,
                        melihat laporan perkembangan, serta memantau presensi siswa
                        melalui menu yang tersedia.

                    </div>

                </div>

            </div>

        </div>

    </div>

    
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <h5 class="fw-bold mb-0">

                <i class="bi bi-building me-2"></i>

                Daftar Kelas

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                    <tr>

                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Wali Kelas</th>
                        <th class="text-center">Jumlah Siswa</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr>

                        <td><?php echo e($i+1); ?></td>

                        <td><?php echo e($k->nama_kelas); ?></td>

                        <td><?php echo e($k->tahun_ajaran); ?></td>

                        <td><?php echo e($k->user->name ?? '-'); ?></td>

                        <td class="text-center">

                            <span class="badge bg-success rounded-pill px-3">

                                <?php echo e($k->siswa->count()); ?>


                            </span>

                        </td>

                    </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>

                        <td colspan="5" class="text-center text-muted py-4">

                            Belum ada data kelas.

                        </td>

                    </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/kepsek/dashboard.blade.php ENDPATH**/ ?>