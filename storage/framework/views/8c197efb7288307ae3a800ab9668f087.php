

<?php $__env->startSection('title', 'Input Penilaian — '.$siswa->nama_siswa); ?>

<?php $__env->startSection('content'); ?>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-1"><?php echo e($siswa->nama_siswa); ?></h5>
            <small class="text-muted">
                NIS : <?php echo e($siswa->nis); ?> |
                Semester <?php echo e($semester); ?>

            </small>
        </div>

        <a href="<?php echo e(route('guru.penilaian.index')); ?>" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?php echo e(route('guru.penilaian.store',$siswa->id_siswa)); ?>"
      method="POST"
      enctype="multipart/form-data">

<?php echo csrf_field(); ?>

<input type="hidden" name="semester" value="<?php echo e($semester); ?>">

<?php $__currentLoopData = $aspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-success text-white">
        <strong><?php echo e($a->urutan); ?>. <?php echo e($a->nama_aspek); ?></strong>
    </div>

    <div class="card-body">

        
        
        
        <div class="table-responsive mb-3">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Capaian Pembelajaran</th>
                        <th class="text-center">BB</th>
                        <th class="text-center">MB</th>
                        <th class="text-center">BSH</th>
                        <th class="text-center">BSB</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $a->indikatorPenilaian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ind): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php
                            $existing = $penilaianExisting[$ind->id_indikator] ?? null;
                        ?>

                        <tr>
                            <td class="text-center"><?php echo e($ind->urutan); ?></td>
                            <td><?php echo e($ind->capaian_pembelajaran); ?></td>

                            <?php $__currentLoopData = ['BB','MB','BSH','BSB']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nilai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="text-center">
                                    <input type="radio"
                                        name="penilaian[<?php echo e($ind->id_indikator); ?>][nilai]"
                                        value="<?php echo e($nilai); ?>"
                                        class="form-check-input"
                                        <?php echo e(($existing?->nilai ?? '') == $nilai ? 'checked' : ''); ?>

                                        required>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        
        
        <div class="mb-3">
            <label class="form-label fw-bold">Deskripsi Perkembangan</label>
            <textarea name="deskripsi[<?php echo e($a->id_aspek); ?>]"
                      class="form-control"
                      rows="3"><?php echo e($deskripsiAspek[$a->id_aspek]->deskripsi ?? ''); ?></textarea>
        </div>

        
        
        
        <div class="row">

            <?php for($i = 0; $i < 3; $i++): ?>

                <?php
                    $foto = $deskripsiAspek[$a->id_aspek]->{'foto'.($i+1)} ?? null;
                ?>

                <div class="col-md-4 text-center mb-3">

                    <?php if($foto): ?>
                        <img src="<?php echo e(asset('storage/'.$foto)); ?>"
                             class="img-thumbnail mb-2"
                             style="height:120px; object-fit:cover;">
                    <?php else: ?>
                        <div class="border p-4 mb-2 text-muted">
                            No Image
                        </div>
                    <?php endif; ?>

                    <input type="file"
                           name="foto[<?php echo e($a->id_aspek); ?>][<?php echo e($i); ?>]"
                           class="form-control form-control-sm"
                           accept="image/*">

                </div>

            <?php endfor; ?>

        </div>

    </div>
</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<div class="mb-5">
    <button class="btn btn-success">
        <i class="bi bi-save"></i> Simpan Penilaian
    </button>
</div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projects\siakad-tk-alikhlas\resources\views/guru/penilaian/show.blade.php ENDPATH**/ ?>