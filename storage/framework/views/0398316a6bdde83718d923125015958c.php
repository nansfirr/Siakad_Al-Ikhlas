<?php
    use App\Models\PengaturanSekolah;
    $pengaturan = PengaturanSekolah::first();
?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid vh-100">
    <div class="row h-100">

        <!-- Bagian Kiri -->
        <div class="col-lg-7 d-none d-lg-flex bg-success text-white justify-content-center align-items-center">

            <div class="text-center px-5">

                <?php if($pengaturan && $pengaturan->logo): ?>
                    <img src="<?php echo e(asset('storage/'.$pengaturan->logo)); ?>"
                         width="120"
                         class="mb-4"
                         alt="Logo Sekolah">
                <?php else: ?>
                    <i class="bi bi-mortarboard-fill display-1 mb-4"></i>
                <?php endif; ?>

                <h1 class="fw-bold">
                    <?php echo e($pengaturan->nama_sekolah ?? 'SIAKAD TK AL-IKHLAS'); ?>

                </h1>

                <h4 class="mb-4">
                    <?php echo e($pengaturan->alamat ?? 'Taliwang'); ?>

                </h4>

                <p class="fs-5">
                    Sistem Informasi Akademik
                    Pengelolaan Penilaian Perkembangan Anak
                    Berbasis Web.
                </p>

            </div>

        </div>

        <!-- Bagian Login -->
        <div class="col-lg-5 d-flex justify-content-center align-items-center bg-light">

            <div class="card shadow border-0 rounded-4 p-4" style="width:420px">

                <div class="text-center mb-4">

                    <i class="bi bi-person-circle text-success" style="font-size:70px"></i>

                    <h3 class="fw-bold mt-2">
                        Login
                    </h3>

                    <p class="text-muted">
                        Masukkan akun Anda
                    </p>

                </div>

                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label">Email</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="<?php echo e(old('email')); ?>"
                            required
                            autofocus>

                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required>

                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Login
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\siakad-tk-alikhlas\resources\views/auth/login.blade.php ENDPATH**/ ?>