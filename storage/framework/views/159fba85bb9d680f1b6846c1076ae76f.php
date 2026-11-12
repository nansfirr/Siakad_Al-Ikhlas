

<?php $__env->startSection('title', 'Input Presensi'); ?>

<?php $__env->startSection('content'); ?>


<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">

        <form method="GET"
              action="<?php echo e(route('guru.presensi.index')); ?>"
              class="row g-2 align-items-end">

            <div class="col-md-3">
                <label class="form-label fw-semibold small">
                    Pilih Kelas
                </label>

                <select name="id_kelas"
                        class="form-select form-select-sm"
                        onchange="this.form.submit()">

                    <?php $__currentLoopData = $kelasSaya; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <option value="<?php echo e($k->id_kelas); ?>"
                            <?php echo e($kelasId==$k->id_kelas ? 'selected' : ''); ?>>

                            <?php echo e($k->nama_kelas); ?>

                            (<?php echo e($k->tahun_ajaran); ?>)

                        </option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold small">
                    Semester
                </label>

                <select name="semester"
                        class="form-select form-select-sm"
                        onchange="this.form.submit()">

                    <option value="1"
                        <?php echo e($semester=='1' ? 'selected':''); ?>>
                        Semester 1
                    </option>

                    <option value="2"
                        <?php echo e($semester=='2' ? 'selected':''); ?>>
                        Semester 2
                    </option>

                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold small">
                    Tahun Ajaran
                </label>

                <input
                    type="text"
                    name="tahun_ajaran"
                    class="form-control form-control-sm"
                    value="<?php echo e($tahunAjaran); ?>"
                    onchange="this.form.submit()">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold small">
                    Tanggal
                </label>

                <input
                    type="date"
                    name="tanggal"
                    class="form-control form-control-sm"
                    value="<?php echo e($tanggal); ?>"
                    onchange="this.form.submit()">
            </div>

        </form>

    </div>
</div>



<div class="card border-0 shadow-sm">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h6 class="fw-bold mb-0">
            Daftar Presensi —
            <?php echo e(\Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y')); ?>

        </h6>

        <span class="badge bg-success">
            <?php echo e($siswa->count()); ?> Siswa
        </span>

    </div>

    <div class="card-body">

        <?php if($siswa->isEmpty()): ?>

            <p class="text-center text-muted">
                Belum ada siswa pada kelas ini.
            </p>

        <?php else: ?>

        <form action="<?php echo e(route('guru.presensi.store')); ?>"
              method="POST">

            <?php echo csrf_field(); ?>

            <input type="hidden"
                   name="id_kelas"
                   value="<?php echo e($kelasId); ?>">

            <input type="hidden"
                   name="tanggal"
                   value="<?php echo e($tanggal); ?>">

            <input type="hidden"
                   name="semester"
                   value="<?php echo e($semester); ?>">

            <input type="hidden"
                   name="tahun_ajaran"
                   value="<?php echo e($tahunAjaran); ?>">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>No</th>

                            <th>Nama Siswa</th>

                            <th class="text-center">
                                Hadir
                            </th>

                            <th class="text-center">
                                Sakit
                            </th>

                            <th class="text-center">
                                Izin
                            </th>

                            <th class="text-center">
                                Tanpa Ket.
                            </th>

                            <th>Keterangan</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php
                            $existing = $presensiHariIni[$s->id_siswa] ?? null;
                        ?>

                        <tr>

                            <td><?php echo e($i+1); ?></td>

                            <td><?php echo e($s->nama_siswa); ?></td>

                            <?php $__currentLoopData = ['hadir','sakit','izin','tanpa_keterangan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <td class="text-center">

                                <div class="form-check d-flex justify-content-center">

                                    <input
                                        type="radio"
                                        class="form-check-input"

                                        name="presensi[<?php echo e($s->id_siswa); ?>][status]"

                                        value="<?php echo e($status); ?>"

                                        <?php echo e(($existing?->status ?? 'hadir') == $status ? 'checked' : ''); ?>


                                        required>

                                </div>

                            </td>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <td>

                                <input
                                    type="text"

                                    class="form-control form-control-sm"

                                    name="presensi[<?php echo e($s->id_siswa); ?>][keterangan]"

                                    value="<?php echo e($existing?->keterangan); ?>"

                                    placeholder="Opsional">

                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>

                </table>

            </div>

            <button class="btn btn-success">

                <i class="bi bi-save"></i>

                Simpan Presensi

            </button>

        </form>

        <?php endif; ?>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/guru/presensi/index.blade.php ENDPATH**/ ?>