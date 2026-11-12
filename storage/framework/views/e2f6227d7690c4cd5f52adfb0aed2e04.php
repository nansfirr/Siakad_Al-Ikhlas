

<?php $__env->startSection('title', 'Laporan Perkembangan'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header">
            <h4 class="mb-0">Laporan Perkembangan Seluruh Siswa</h4>
        </div>

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-3">
                        <label>Kelas</label>
                        <select name="id_kelas" class="form-control">
                            <option value="">Semua Kelas</option>

                            <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($k->id_kelas); ?>"
                                    <?php echo e($kelasId == $k->id_kelas ? 'selected' : ''); ?>>
                                    <?php echo e($k->nama_kelas); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Semester</label>

                        <select name="semester" class="form-control">
                            <option value="1" <?php echo e($semester == 1 ? 'selected' : ''); ?>>
                                Semester 1
                            </option>

                            <option value="2" <?php echo e($semester == 2 ? 'selected' : ''); ?>>
                                Semester 2
                            </option>
                        </select>

                    </div>

                    <div class="col-md-3">
                        <label>Tahun Ajaran</label>

                        <input
                            type="text"
                            name="tahun_ajaran"
                            class="form-control"
                            value="<?php echo e($tahunAjaran); ?>">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            Tampilkan
                        </button>
                    </div>

                </div>

            </form>

            <hr>

            <table class="table table-bordered table-striped">

                <thead class="table-light">

                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>

                        <?php $__currentLoopData = $aspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="text-center">
                                <?php echo e($a->nama_aspek); ?>

                            </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tr>

                </thead>

                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <tr>

                            <td><?php echo e($i + 1); ?></td>

                            <td><?php echo e($s->nama_siswa); ?></td>

                            <td><?php echo e($s->kelas->nama_kelas ?? '-'); ?></td>

                            <?php $__currentLoopData = $aspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <td class="text-center">

                                    <?php echo e($rekapNilai[$s->id_siswa][$a->id_aspek] ?? '-'); ?>


                                </td>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>

                            <td colspan="<?php echo e(count($aspek) + 3); ?>" class="text-center">

                                Belum ada data.

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/kepsek/laporan/perkembangan.blade.php ENDPATH**/ ?>