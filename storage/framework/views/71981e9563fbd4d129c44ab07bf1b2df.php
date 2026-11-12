<?php
    $role = auth()->user()->role;
?>

<?php if($role === 'admin'): ?>

    <small class="text-white-50 px-3 mb-2">
        <i class="bi bi-grid me-1"></i>
        MENU UTAMA
    </small>

    <a href="<?php echo e(route('admin.dashboard')); ?>"
       class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
        <i class="bi bi-speedometer2 me-2"></i>
        Dashboard
    </a>

    <a href="<?php echo e(route('admin.siswa.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('admin.siswa*') ? 'active' : ''); ?>">
        <i class="bi bi-people me-2"></i>
        Data Siswa
    </a>

    <a href="<?php echo e(route('admin.kelas.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('admin.kelas*') ? 'active' : ''); ?>">
        <i class="bi bi-door-open me-2"></i>
        Data Kelas
    </a>

    <a href="<?php echo e(route('admin.pengguna.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('admin.pengguna*') ? 'active' : ''); ?>">
        <i class="bi bi-person-gear me-2"></i>
        Data Pengguna
    </a>

    <hr class="border-light">

    <small class="text-white-50 px-3 mb-2">
        <i class="bi bi-database me-1"></i>
        DATA MASTER
    </small>

    <a href="<?php echo e(route('admin.aspek.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('admin.aspek*') ? 'active' : ''); ?>">
        <i class="bi bi-journal-text me-2"></i>
        Aspek Perkembangan
    </a>

    <a href="<?php echo e(route('admin.indikator.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('admin.indikator*') ? 'active' : ''); ?>">
        <i class="bi bi-list-check me-2"></i>
        Indikator Penilaian
    </a>

    <a href="<?php echo e(route('admin.katagori.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('admin.katagori*') ? 'active' : ''); ?>">
        <i class="bi bi-tags me-2"></i>
        Kategori Kegiatan
    </a>

    <a href="<?php echo e(route('admin.item.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('admin.item*') ? 'active' : ''); ?>">
        <i class="bi bi-card-list me-2"></i>
        Item Kegiatan
    </a>

    <hr class="border-light">

    <small class="text-white-50 px-3 mb-2">
        <i class="bi bi-gear me-1"></i>
        PENGATURAN
    </small>

    <a href="<?php echo e(route('admin.pengaturan.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('admin.pengaturan*') ? 'active' : ''); ?>">
        <i class="bi bi-building me-2"></i>
        Profil Sekolah
    </a>

<?php elseif($role === 'guru'): ?>

    <small class="text-white-50 px-3 mb-2">
        <i class="bi bi-person-workspace me-1"></i>
        MENU GURU
    </small>

    <a href="<?php echo e(route('guru.dashboard')); ?>"
       class="nav-link <?php echo e(request()->routeIs('guru.dashboard') ? 'active' : ''); ?>">
        <i class="bi bi-speedometer2 me-2"></i>
        Dashboard
    </a>

    <a href="<?php echo e(route('guru.presensi.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('guru.presensi*') ? 'active' : ''); ?>">
        <i class="bi bi-calendar-check me-2"></i>
        Input Presensi
    </a>

    <a href="<?php echo e(route('guru.penilaian.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('guru.penilaian*') ? 'active' : ''); ?>">
        <i class="bi bi-stars me-2"></i>
        Penilaian 6 Aspek
    </a>

    <a href="<?php echo e(route('guru.kegiatan.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('guru.kegiatan*') ? 'active' : ''); ?>">
        <i class="bi bi-journal-bookmark me-2"></i>
        Penilaian Kegiatan
    </a>

    <a href="<?php echo e(route('guru.antropometri.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('guru.antropometri*') ? 'active' : ''); ?>">
        <i class="bi bi-heart-pulse me-2"></i>
        Antropometri
    </a>

    <a href="<?php echo e(route('guru.refleksi.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('guru.refleksi*') ? 'active' : ''); ?>">
        <i class="bi bi-pencil-square me-2"></i>
        Refleksi Guru
    </a>

    <a href="<?php echo e(route('guru.raport.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('guru.raport*') ? 'active' : ''); ?>">
        <i class="bi bi-file-earmark-pdf me-2"></i>
        Generate Raport
    </a>

    <a href="<?php echo e(route('guru.laporan.index')); ?>"
       class="nav-link <?php echo e(request()->routeIs('guru.laporan*') ? 'active' : ''); ?>">
        <i class="bi bi-bar-chart-line me-2"></i>
        Laporan Rekapitulasi
    </a>

<?php elseif($role === 'kepsek'): ?>

    <small class="text-white-50 px-3 mb-2">
        <i class="bi bi-person-badge me-1"></i>
        MENU KEPALA SEKOLAH
    </small>

    <a href="<?php echo e(route('kepsek.dashboard')); ?>"
       class="nav-link <?php echo e(request()->routeIs('kepsek.dashboard') ? 'active' : ''); ?>">
        <i class="bi bi-speedometer2 me-2"></i>
        Dashboard
    </a>

    <a href="<?php echo e(route('kepsek.laporan.perkembangan')); ?>"
       class="nav-link <?php echo e(request()->routeIs('kepsek.laporan.perkembangan') ? 'active' : ''); ?>">
        <i class="bi bi-graph-up-arrow me-2"></i>
        Laporan Perkembangan
    </a>

    <a href="<?php echo e(route('kepsek.laporan.presensi')); ?>"
       class="nav-link <?php echo e(request()->routeIs('kepsek.laporan.presensi') ? 'active' : ''); ?>">
        <i class="bi bi-calendar3 me-2"></i>
        Laporan Presensi
    </a>

<?php endif; ?><?php /**PATH D:\Projects\siakad-tk-alikhlas\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>