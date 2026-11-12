

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-4">
    <h3 class="fw-bold text-success">
        Dashboard Admin
    </h3>
    <p class="text-muted mb-0">
        Selamat datang di Sistem Informasi Akademik TK Al-Ikhlas Taliwang.
    </p>
</div>

<div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <small class="text-muted">Total Siswa</small>
                    <h2 class="fw-bold text-success mb-0">
                        <?php echo e($data['total_siswa']); ?>

                    </h2>
                </div>

                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-people-fill fs-2 text-success"></i>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <small class="text-muted">Total Kelas</small>
                    <h2 class="fw-bold text-primary mb-0">
                        <?php echo e($data['total_kelas']); ?>

                    </h2>
                </div>

                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-door-open-fill fs-2 text-primary"></i>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <small class="text-muted">Total Guru</small>
                    <h2 class="fw-bold text-warning mb-0">
                        <?php echo e($data['total_guru']); ?>

                    </h2>
                </div>

                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-person-badge-fill fs-2 text-warning"></i>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <small class="text-muted">Kepala Sekolah</small>
                    <h2 class="fw-bold text-info mb-0">
                        <?php echo e($data['total_kepsek']); ?>

                    </h2>
                </div>

                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-person-workspace fs-2 text-info"></i>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-clock-history me-2 text-success"></i>
            Aktivitas Terbaru
        </h5>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                <tr>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Aktivitas</th>
                    <th>Waktu</th>
                </tr>

                </thead>

                <tbody>

                <tr>
                    <td>1</td>
                    <td>Admin Utama</td>
                    <td>Menambahkan data siswa baru</td>
                    <td>5 menit yang lalu</td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Guru Kelas A</td>
                    <td>Menginput penilaian perkembangan siswa</td>
                    <td>1 jam yang lalu</td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Admin Utama</td>
                    <td>Memperbarui data aspek perkembangan</td>
                    <td>3 jam yang lalu</td>
                </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>