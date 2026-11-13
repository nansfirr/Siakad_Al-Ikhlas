<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Raport <?php echo e($siswa->nama_siswa); ?></title>
<style>
    @page {
        size: A4 portrait;
        margin: 0;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: DejaVu Sans, sans-serif;
        font-size: 11px;
        color: #111;
        line-height: 1.4;
    }

    .page {
        position: relative;
        width: 100%;
        height: 297mm;
        page-break-after: always;
        overflow: hidden;
    }

    .page:last-child {
        page-break-after: avoid;
    }

    .bg-full {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -2;
    }

    .content-wrap {
        position: relative;
        padding: 14mm 18mm 24mm 18mm;
        z-index: 1;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    /* Tabel Capaian & Kegiatan */
    .table-capaian th,
    .table-capaian td {
        border: 1px solid #222;
        padding: 5px 7px;
        vertical-align: middle;
        font-size: 10.5px;
    }

    .table-capaian th {
        font-weight: bold;
        text-align: center;
    }

    .table-kegiatan th,
    .table-kegiatan td {
        border: 1px solid #222;
        padding: 3.5px 6px;
        vertical-align: middle;
        font-size: 10px;
    }

    .table-kegiatan th {
        font-weight: bold;
        text-align: center;
    }

    .checkmark {
        font-family: DejaVu Sans, sans-serif;
        font-size: 13px;
        font-weight: bold;
        color: #1b365d;
        line-height: 1;
    }

    /* Kotak Deskripsi */
    .desc-wrapper {
        margin-top: 12px;
        position: relative;
    }

    .desc-badge-row {
        text-align: right;
        padding-right: 10px;
        margin-bottom: -11px;
        position: relative;
        z-index: 3;
    }

    .desc-badge {
        display: inline-block;
        background-color: #2196c4;
        color: #ffffff;
        font-weight: bold;
        font-size: 10.5px;
        padding: 5px 28px;
        border-radius: 6px;
        border: 1px solid #1779a1;
        letter-spacing: 0.3px;
    }

    .desc-box {
        border: 2px solid #f5b400;
        border-radius: 26px 0 26px 0;
        background-color: #ffffff;
        padding: 18px 16px 14px 16px;
        min-height: 110px;
        text-align: justify;
        font-size: 10.5px;
        line-height: 1.5;
    }

    /* Kotak Pose Kegiatan */
    .pose-wrapper {
        margin-top: 12px;
        position: relative;
    }

    .pose-badge-row {
        text-align: left;
        padding-left: 16px;
        margin-bottom: -11px;
        position: relative;
        z-index: 3;
    }

    .pose-badge {
        display: inline-block;
        background-color: #6da63c;
        color: #ffffff;
        font-weight: bold;
        font-size: 10.5px;
        padding: 5px 24px;
        border-radius: 6px;
        border: 1px solid #55872a;
        letter-spacing: 0.3px;
    }

    .pose-badge-red {
        background-color: #b71c1c;
        border-color: #8e0000;
    }

    .pose-box {
        border: 2px solid #2e9b4f;
        background-color: #ffffff;
        padding: 18px 10px 12px 10px;
        min-height: 195px;
    }

    /* Kotak Refleksi */
    .refleksi-wrapper {
        margin-top: 18px;
        position: relative;
    }

    .refleksi-badge-row {
        text-align: right;
        padding-right: 12px;
        margin-bottom: -12px;
        position: relative;
        z-index: 3;
    }

    .refleksi-badge {
        display: inline-block;
        background-color: #7c3812;
        color: #ffffff;
        font-weight: bold;
        font-size: 11px;
        padding: 6px 36px;
        border-radius: 6px;
        border: 1px solid #4e2107;
    }

    .refleksi-box {
        border: 2px solid #f5b400;
        border-radius: 30px 0 30px 0;
        background-color: #ffffff;
        padding: 24px 20px 20px 20px;
        min-height: 215px;
        text-align: justify;
        font-size: 11px;
        line-height: 1.55;
    }

    /* Footer LCPA */
    .footer-lcpa {
        position: absolute;
        bottom: 4mm;
        left: 16mm;
        right: 16mm;
        height: 22mm;
        border-top: 1px solid #d5dce2;
        z-index: 5;
    }

    .footer-kids {
        position: absolute;
        top: 1px;
        left: 50%;
        margin-left: -42px;
        width: 84px;
        height: auto;
    }

    .footer-pagenum {
        position: absolute;
        top: 6px;
        right: 4px;
        font-size: 10px;
        color: #444;
    }
</style>
</head>
<body>

<?php
    // Helper konversi file gambar lokal ke base64 agar 100% muncul di DomPDF
    $imgToBase64 = function (?string $relativePath, bool $isPublicAsset = false): ?string {
        if (empty($relativePath)) {
            return null;
        }

        $candidates = [];
        if ($isPublicAsset) {
            $candidates[] = public_path($relativePath);
        } else {
            $clean = ltrim($relativePath, '/\\');
            $candidates[] = public_path('storage/' . $clean);
            $candidates[] = storage_path('app/public/' . $clean);
            $candidates[] = public_path($clean);
        }

        foreach ($candidates as $fullPath) {
            if (is_file($fullPath)) {
                $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                $mime = match ($ext) {
                    'png'  => 'image/png',
                    'gif'  => 'image/gif',
                    'webp' => 'image/webp',
                    default => 'image/jpeg',
                };
                $data = @file_get_contents($fullPath);
                if ($data !== false) {
                    return 'data:' . $mime . ';base64,' . base64_encode($data);
                }
            }
        }
        return null;
    };

    // Aset dekoratif raport
    $bgCoverBase64    = $imgToBase64('images/raport/bg-cover.png', true);
    $bgPageBase64     = $imgToBase64('images/raport/bg-page.png', true);
    $waveTopRight     = $imgToBase64('images/raport/wave-corner.png', true);
    $waveBottomLeft   = $imgToBase64('images/raport/wave-bottom-left.png', true);
    $logoDefault      = $imgToBase64('images/raport/logo-default.png', true);
    $kidsCover        = $imgToBase64('images/raport/kids-cover.png', true);
    $kidsFooter       = $imgToBase64('images/raport/kids-footer.png', true);
    $kidsTwo          = $imgToBase64('images/raport/kids-two.png', true);
    $ribbonPink       = $imgToBase64('images/raport/ribbon-pink.png', true);
    $ribbonGreen      = $imgToBase64('images/raport/ribbon-green.png', true);

    // Logo sekolah (gunakan dari pengaturan jika ada & valid, jika tidak pakai logo default TK Al-Ikhlas)
    $logoSekolah = $imgToBase64($pengaturan->logo ?? null) ?? $logoDefault;

    // Foto siswa (opsional untuk halaman biodata)
    $fotoSiswaBase64 = $imgToBase64($siswa->foto ?? null);

    // Format nama kelompok
    $namaKelasRaw = trim($siswa->kelas->nama_kelas ?? 'B');
    $labelKelompok = stripos($namaKelasRaw, 'kelompok') === 0 ? $namaKelasRaw : ('Kelompok ' . $namaKelasRaw);
    $kodeKelompok  = trim(preg_replace('/^kelompok\s+/i', '', $namaKelasRaw));

    $namaSekolahUpper = strtoupper($pengaturan->nama_sekolah ?? 'TK AL-IKHLAS TALIWANG');
    $tahunAjaranDash  = str_replace('/', '-', $tahun_ajaran ?? '2025-2026');
    $semesterLabel    = ($semester == 1) ? 'Ganjil' : 'Genap';
    $semesterKata     = ($semester == 1) ? '1 (Satu)' : '2 (Dua)';
?>




<div class="page">
    <?php if($bgCoverBase64): ?>
        <img src="<?php echo e($bgCoverBase64); ?>" class="bg-full">
    <?php endif; ?>

    <?php if($waveTopRight): ?>
        <img src="<?php echo e($waveTopRight); ?>" style="position:absolute; top:0; right:0; width:260px; height:auto; z-index:0;">
    <?php endif; ?>

    <?php if($waveBottomLeft): ?>
        <img src="<?php echo e($waveBottomLeft); ?>" style="position:absolute; bottom:0; left:0; width:270px; height:auto; z-index:0;">
    <?php endif; ?>

    <div class="content-wrap" style="padding-top:15mm; text-align:center;">
        <?php if($logoSekolah): ?>
            <img src="<?php echo e($logoSekolah); ?>" style="width:76px; height:auto; margin-bottom:6px;">
        <?php endif; ?>

        <div style="font-size:15px; font-weight:bold; letter-spacing:0.3px; line-height:1.35;">
            LAPORAN PENCAPAIAN PERKEMBANGAN ANAK<br>
            (LPPA)
        </div>

        <div style="font-size:21px; font-weight:bold; margin-top:4px; margin-bottom:14px;">
            <?php echo e($namaSekolahUpper); ?>

        </div>

        <?php if($logoSekolah): ?>
            <div style="margin: 6px auto 4px auto;">
                <img src="<?php echo e($logoSekolah); ?>" style="width:142px; height:auto;">
            </div>
        <?php endif; ?>

        <?php if($kidsCover): ?>
            <div style="margin-top: -12px; margin-bottom: -6px;">
                <img src="<?php echo e($kidsCover); ?>" style="width:230px; height:auto;">
            </div>
        <?php endif; ?>

        <div style="
            width: 82%;
            margin: 0 auto;
            border: 2.5px solid #6b9e58;
            border-radius: 14px;
            background-color: #ffffff;
            padding: 12px 20px 14px 20px;
            text-align: center;
        ">
            <div style="font-size:13px; margin-bottom:5px;">Nama Siswa :</div>
            <div style="font-size:15px; font-weight:bold; margin-bottom:5px; text-transform:uppercase;">
                <?php echo e($siswa->nama_siswa); ?>

            </div>
            <div style="font-size:13px;"><?php echo e($labelKelompok); ?></div>
        </div>

        <div style="margin-top: 48px; text-align:center;">
            <div style="font-size:11.5px; font-weight:bold; line-height:1.45;">
                YAYASAN WAKAF<br>
                PONDOK PESANTREN AL-IKHLAS TALIWANG
            </div>
            <div style="font-size:17px; font-weight:bold; margin-top:2px;">
                <?php echo e($namaSekolahUpper); ?>

            </div>
            <div style="font-size:14px; font-weight:bold; margin-top:3px;">
                Semester <?php echo e($semesterLabel); ?> Tahun Ajaran <?php echo e($tahunAjaranDash); ?>

            </div>
        </div>
    </div>
</div>




<div class="page">
    <?php if($bgCoverBase64): ?>
        <img src="<?php echo e($bgCoverBase64); ?>" class="bg-full">
    <?php endif; ?>

    <?php if($logoSekolah): ?>
        <img src="<?php echo e($logoSekolah); ?>" style="position:absolute; top:14mm; right:16mm; width:90px; height:auto; z-index:2;">
    <?php endif; ?>

    <div class="content-wrap" style="padding-top:18mm;">
        <div style="position:relative; text-align:center; margin-bottom:26px;">
            <?php if($ribbonPink): ?>
                <img src="<?php echo e($ribbonPink); ?>" style="width:270px; height:auto;">
                <div style="
                    position:absolute;
                    top:10px;
                    left:0;
                    right:0;
                    text-align:center;
                    color:#ffffff;
                    font-weight:bold;
                    font-size:11px;
                    letter-spacing:0.4px;
                ">
                    PEDOMAN PENILAIAN
                </div>
            <?php else: ?>
                <div style="display:inline-block; background:#ec407a; color:#fff; font-weight:bold; padding:8px 30px; border-radius:20px;">
                    PEDOMAN PENILAIAN
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-left:20mm; margin-top:10mm;">
            <div style="font-size:12px; margin-bottom:10px;">
                PENILAIAN PROGRAM PENGEMBANGAN PESERTA DIDIK
            </div>

            <table style="width:85%; margin-left:18mm; border:none;">
                <tr>
                    <td style="border:none; width:35%; padding:6px 0; font-size:12px;">BB</td>
                    <td style="border:none; width:5%; padding:6px 0; font-size:12px;">:</td>
                    <td style="border:none; padding:6px 0; font-size:12px;">Belum Berkembang</td>
                </tr>
                <tr>
                    <td style="border:none; padding:6px 0; font-size:12px;">MB</td>
                    <td style="border:none; padding:6px 0; font-size:12px;">:</td>
                    <td style="border:none; padding:6px 0; font-size:12px;">Mulai Berkembang</td>
                </tr>
                <tr>
                    <td style="border:none; padding:6px 0; font-size:12px;">BSH</td>
                    <td style="border:none; padding:6px 0; font-size:12px;">:</td>
                    <td style="border:none; padding:6px 0; font-size:12px;">Berkembang Sesuai Harapan</td>
                </tr>
                <tr>
                    <td style="border:none; padding:6px 0; font-size:12px;">BSB</td>
                    <td style="border:none; padding:6px 0; font-size:12px;">:</td>
                    <td style="border:none; padding:6px 0; font-size:12px;">Berkembang Sangat Baik</td>
                </tr>
            </table>
        </div>
    </div>

    <?php if($kidsTwo): ?>
        <img src="<?php echo e($kidsTwo); ?>" style="position:absolute; bottom:6mm; left:18mm; width:215px; height:auto; z-index:2;">
    <?php endif; ?>
</div>




<div class="page">
    <?php if($bgCoverBase64): ?>
        <img src="<?php echo e($bgCoverBase64); ?>" class="bg-full">
    <?php endif; ?>

    <?php if($logoSekolah): ?>
        <img src="<?php echo e($logoSekolah); ?>" style="position:absolute; top:14mm; right:16mm; width:90px; height:auto; z-index:2;">
    <?php endif; ?>

    <div class="content-wrap" style="padding-top:18mm;">
        <div style="position:relative; text-align:center; margin-bottom:22px;">
            <?php if($ribbonGreen): ?>
                <img src="<?php echo e($ribbonGreen); ?>" style="width:315px; height:auto;">
                <div style="
                    position:absolute;
                    top:14px;
                    left:0;
                    right:0;
                    text-align:center;
                    color:#ffffff;
                    font-weight:bold;
                    font-size:16px;
                ">
                    Data Diri Anak/Siswa
                </div>
            <?php else: ?>
                <div style="display:inline-block; background:#558b2f; color:#fff; font-weight:bold; padding:8px 30px; border-radius:20px;">
                    Data Diri Anak/Siswa
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-left:14mm; margin-right:10mm;">
            <div style="font-weight:bold; font-size:12px; margin-bottom:6px;">
                A. &nbsp;DATA PRIBADI SISWA
            </div>

            <table style="width:100%; border:none; font-size:11.5px;">
                <tr>
                    <td style="border:none; width:6%; padding:3.5px 0;">1.</td>
                    <td style="border:none; width:36%; padding:3.5px 0;">Nama lengkap anak/siswa</td>
                    <td style="border:none; width:3%; padding:3.5px 0;">:</td>
                    <td style="border:none; padding:3.5px 0; font-weight:bold;"><?php echo e(strtoupper($siswa->nama_siswa)); ?></td>
                </tr>
                <tr>
                    <td style="border:none; padding:3.5px 0;">2.</td>
                    <td style="border:none; padding:3.5px 0;">Tempat/Tgl Lahir</td>
                    <td style="border:none; padding:3.5px 0;">:</td>
                    <td style="border:none; padding:3.5px 0;">
                        <?php echo e(!empty($siswa->tempat_lahir) ? $siswa->tempat_lahir . ', ' : 'Taliwang, '); ?><?php echo e($siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-'); ?>

                    </td>
                </tr>
                <tr>
                    <td style="border:none; padding:3.5px 0;">3.</td>
                    <td style="border:none; padding:3.5px 0;">Jenis Kelamin</td>
                    <td style="border:none; padding:3.5px 0;">:</td>
                    <td style="border:none; padding:3.5px 0;"><?php echo e($siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'); ?></td>
                </tr>
                <tr>
                    <td style="border:none; padding:3.5px 0;">4.</td>
                    <td style="border:none; padding:3.5px 0;">Anak ke</td>
                    <td style="border:none; padding:3.5px 0;">:</td>
                    <td style="border:none; padding:3.5px 0;"><?php echo e($siswa->anak_ke ?? '-'); ?></td>
                </tr>
                <tr>
                    <td style="border:none; padding:3.5px 0;">5.</td>
                    <td style="border:none; padding:3.5px 0;">Agama</td>
                    <td style="border:none; padding:3.5px 0;">:</td>
                    <td style="border:none; padding:3.5px 0;"><?php echo e($siswa->agama ?? 'Islam'); ?></td>
                </tr>
                <tr>
                    <td style="border:none; padding:3.5px 0;">6.</td>
                    <td style="border:none; padding:3.5px 0;">Kewarganegaraan</td>
                    <td style="border:none; padding:3.5px 0;">:</td>
                    <td style="border:none; padding:3.5px 0;"><?php echo e($siswa->kewarganegaraan ?? 'Indonesia'); ?></td>
                </tr>
                <tr>
                    <td style="border:none; padding:3.5px 0; vertical-align:top;">7.</td>
                    <td style="border:none; padding:3.5px 0; vertical-align:top;">Alamat</td>
                    <td style="border:none; padding:3.5px 0; vertical-align:top;">:</td>
                    <td style="border:none; padding:3.5px 0; vertical-align:top;">
                        <?php echo e($siswa->alamat ?? ($pengaturan->alamat ?? 'Ponpes Al-Ikhlas, Kec. Taliwang, Kab. Sumbawa Barat.')); ?>

                    </td>
                </tr>
            </table>

            <div style="font-weight:bold; font-size:12px; margin-top:16px; margin-bottom:6px;">
                B. &nbsp;DATA ORANG TUA
            </div>

            <table style="width:100%; border:none; font-size:11.5px;">
                <tr>
                    <td style="border:none; width:6%; padding:3px 0;">8.</td>
                    <td style="border:none; width:36%; padding:3px 0;">Ayah / Wali</td>
                    <td style="border:none; width:3%; padding:3px 0;">:</td>
                    <td style="border:none; padding:3px 0;"></td>
                </tr>
                <tr>
                    <td style="border:none; padding:3px 0;"></td>
                    <td style="border:none; padding:3px 0;">Nama Ayah/Wali</td>
                    <td style="border:none; padding:3px 0;">:</td>
                    <td style="border:none; padding:3px 0;"><?php echo e($siswa->nama_wali ?? '-'); ?></td>
                </tr>
                <tr>
                    <td style="border:none; padding:3px 0;"></td>
                    <td style="border:none; padding:3px 0;">Pekerjaan/Wali</td>
                    <td style="border:none; padding:3px 0;">:</td>
                    <td style="border:none; padding:3px 0;"><?php echo e($siswa->pekerjaan_wali ?? '-'); ?></td>
                </tr>
                <tr>
                    <td style="border:none; padding:3px 0;">9.</td>
                    <td style="border:none; padding:3px 0;">Ibu/Wali</td>
                    <td style="border:none; padding:3px 0;">:</td>
                    <td style="border:none; padding:3px 0;"></td>
                </tr>
                <tr>
                    <td style="border:none; padding:3px 0;"></td>
                    <td style="border:none; padding:3px 0;">Nama Ibu/Wali</td>
                    <td style="border:none; padding:3px 0;">:</td>
                    <td style="border:none; padding:3px 0;"><?php echo e($siswa->nama_ibu ?? '-'); ?></td>
                </tr>
                <tr>
                    <td style="border:none; padding:3px 0;"></td>
                    <td style="border:none; padding:3px 0;">Pekerjaan Ibu/Wali</td>
                    <td style="border:none; padding:3px 0;">:</td>
                    <td style="border:none; padding:3px 0;"><?php echo e($siswa->pekerjaan_ibu ?? '-'); ?></td>
                </tr>
            </table>

            <table style="width:100%; border:none; margin-top:18px;">
                <tr>
                    <td style="border:none; width:42%; vertical-align:middle; text-align:center;">
                        <div style="
                            width: 72px;
                            height: 100px;
                            border: 1px solid #6b9e58;
                            margin: 18px auto 0 auto;
                            background: #ffffff;
                            overflow: hidden;
                        ">
                            <?php if($fotoSiswaBase64): ?>
                                <img src="<?php echo e($fotoSiswaBase64); ?>" style="width:72px; height:100px; object-fit:cover;">
                            <?php endif; ?>
                        </div>
                    </td>
                    <td style="border:none; width:58%; vertical-align:top;">
                        <div style="
                            border: 1px solid #6b9e58;
                            border-radius: 18px;
                            padding: 12px 16px;
                            text-align: center;
                            font-size: 11.5px;
                            background: transparent;
                        ">
                            <div>Taliwang, <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?></div>
                            <div style="margin-top:4px;">Kepala Sekolah <?php echo e($pengaturan->nama_sekolah ?? 'TK Al-Ikhlas Taliwang'); ?></div>
                            <div style="height:55px;"></div>
                            <div style="font-weight:bold;"><?php echo e($pengaturan->kepala_sekolah ?? 'Putri Balqis, S.E'); ?></div>
                            <div>NIP. <?php echo e(!empty($pengaturan->nip_kepala) ? $pengaturan->nip_kepala : '-'); ?></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <?php if($kidsTwo): ?>
        <img src="<?php echo e($kidsTwo); ?>" style="position:absolute; bottom:6mm; left:18mm; width:215px; height:auto; z-index:2;">
    <?php endif; ?>
</div>




<?php
    $hurufAspek = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
    $warnaHeaderAspek = [
        0 => '#c5cae9', // A. Nilai Agama dan Moral
        1 => '#e6dec8', // B. Fisik dan Motorik
        2 => '#d5e1c8', // C. Kognitif
        3 => '#dfa8a2', // D. Sosial Emosi
        4 => '#b8bfc6', // E. Bahasa
        5 => '#f3c69f', // F. Seni
    ];
    $lcpaPage = 1;
?>

<?php $__currentLoopData = $aspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $desk = $deskripsi[$a->id_aspek] ?? null;
    $huruf = $hurufAspek[$idx] ?? chr(65 + $idx);
    $headerBg = $warnaHeaderAspek[$idx] ?? '#d5e1c8';
    $namaAspekUpper = strtoupper($a->nama_aspek);

    // Judul kolom capaian sesuai contoh PDF
    $judulKolomCapaian = match ($idx) {
        0 => 'CAPAIAN PEMBELAJARAN NILAI AGAMA DAN MORAL',
        1 => 'CAPAIAN PEMBELAJARAN JATI DIRI',
        default => 'CAPAIAN ' . $namaAspekUpper,
    };

    // Label pose kegiatan sesuai contoh PDF
    $labelPose = match ($idx) {
        0 => 'POSE KEGIATAN AGAMA DAN MORAL',
        1 => 'POSE KEGIATAN MOTORIK',
        default => 'POSE KEGIATAN ' . $namaAspekUpper,
    };

    // Kumpulkan foto yang tersedia (di-convert ke base64)
    $fotosAspek = [];
    if ($desk) {
        foreach (['foto1', 'foto2', 'foto3'] as $fCol) {
            if (!empty($desk->$fCol)) {
                $b64 = $imgToBase64($desk->$fCol);
                if ($b64) {
                    $fotosAspek[] = $b64;
                }
            }
        }
    }
?>

<div class="page">
    <?php if($bgPageBase64): ?>
        <img src="<?php echo e($bgPageBase64); ?>" class="bg-full">
    <?php endif; ?>

    <div class="content-wrap">
        <?php if($loop->first): ?>
            <div style="text-align:center; font-weight:bold; font-size:12.5px; margin-bottom:10px;">
                LAPORAN CAPAIAN PEMBELAJARAN ANAK
            </div>

            <table style="width:65%; border:none; margin-bottom:8px; font-size:11.5px; font-weight:bold;">
                <tr>
                    <td style="border:none; width:26%; padding:2px 0;">Nama</td>
                    <td style="border:none; width:4%; padding:2px 0;">:</td>
                    <td style="border:none; padding:2px 0;"><?php echo e($siswa->nama_siswa); ?></td>
                </tr>
                <tr>
                    <td style="border:none; padding:2px 0;">Kelompok</td>
                    <td style="border:none; padding:2px 0;">:</td>
                    <td style="border:none; padding:2px 0;"><?php echo e($kodeKelompok); ?></td>
                </tr>
                <tr>
                    <td style="border:none; padding:2px 0;">Semester</td>
                    <td style="border:none; padding:2px 0;">:</td>
                    <td style="border:none; padding:2px 0;"><?php echo e($semesterKata); ?></td>
                </tr>
            </table>
        <?php endif; ?>

        <div style="font-weight:bold; font-size:12px; margin-bottom:6px; margin-top:<?php echo e($loop->first ? '4px' : '2px'); ?>;">
            <?php echo e($huruf); ?>. &nbsp;<?php echo e($namaAspekUpper); ?>

        </div>

        <table class="table-capaian">
            <thead>
                <tr style="background-color: <?php echo e($headerBg); ?>;">
                    <th rowspan="2" width="7%">NO</th>
                    <th rowspan="2" width="61%"><?php echo e($judulKolomCapaian); ?></th>
                    <th colspan="4" width="32%">TINGKAT KETERCAPAIAN</th>
                </tr>
                <tr style="background-color: <?php echo e($headerBg); ?>;">
                    <th width="8%">BB</th>
                    <th width="8%">MB</th>
                    <th width="8%">BSH</th>
                    <th width="8%">BSB</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $a->indikatorPenilaian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indikator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $nilaiRow = $penilaian[$indikator->id_indikator][0]->nilai ?? '';
                    ?>
                    <tr style="background-color: rgba(255,255,255,0.75);">
                        <td class="center bold"><?php echo e($indikator->urutan); ?></td>
                        <td><?php echo e($indikator->capaian_pembelajaran); ?></td>
                        <td class="center"><?php echo $nilaiRow === 'BB' ? '<span class="checkmark">&#10004;</span>' : ''; ?></td>
                        <td class="center"><?php echo $nilaiRow === 'MB' ? '<span class="checkmark">&#10004;</span>' : ''; ?></td>
                        <td class="center"><?php echo $nilaiRow === 'BSH' ? '<span class="checkmark">&#10004;</span>' : ''; ?></td>
                        <td class="center"><?php echo $nilaiRow === 'BSB' ? '<span class="checkmark">&#10004;</span>' : ''; ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        
        <div class="desc-wrapper">
            <div class="desc-badge-row">
                <span class="desc-badge">DESKRIPSI CAPAIAN PERKEMBANGAN</span>
            </div>
            <div class="desc-box">
                <p style="margin:0; text-indent:28px;">
                    <?php echo e($desk->deskripsi ?? '-'); ?>

                </p>
            </div>
        </div>

        
        <div class="pose-wrapper">
            <div class="pose-badge-row">
                <span class="pose-badge <?php echo e($idx === 1 ? 'pose-badge-red' : ''); ?>">
                    <?php echo e($labelPose); ?>

                </span>
            </div>
            <div class="pose-box">
                <?php if(count($fotosAspek) > 0): ?>
                    <table style="width:100%; border:none;">
                        <tr>
                            <?php $__currentLoopData = $fotosAspek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fotoSrc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td style="border:none; text-align:center; vertical-align:middle; padding:4px; width:<?php echo e(round(100 / count($fotosAspek))); ?>%;">
                                    <img src="<?php echo e($fotoSrc); ?>" style="
                                        max-width: <?php echo e(count($fotosAspek) == 1 ? '260px' : (count($fotosAspek) == 2 ? '230px' : '165px')); ?>;
                                        height: 175px;
                                        object-fit: cover;
                                        border-radius: 2px;
                                    ">
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </table>
                <?php else: ?>
                    <div style="text-align:center; color:#888; padding:65px 0; font-size:10px;">
                        Belum ada dokumentasi foto kegiatan
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="footer-lcpa">
        <?php if($kidsFooter): ?>
            <img src="<?php echo e($kidsFooter); ?>" class="footer-kids">
        <?php endif; ?>
        <div class="footer-pagenum">
            <strong><?php echo e($lcpaPage++); ?></strong> | <span style="letter-spacing:2px; color:#777;">L C P A</span>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




<?php
    $warnaKategori = [
        0 => '#95b3d7', // 1. Hafalan Surat Pendek & Hadist
        1 => '#c4bd97', // 2. Hafalan Doa Sehari-hari
        2 => '#ccc0da', // 3. Hafalan Bacaan Sholat
        3 => '#95b3d7', // 4. Hafalan Lainnya
        4 => '#95b3d7', // 5. Ekstrakurikuler
    ];

    // Bagi kategori kegiatan: halaman pertama untuk 2 kategori pertama, halaman kedua untuk sisanya
    $halamanKategori = [
        $katagori->slice(0, 2),
        $katagori->slice(2),
    ];
?>

<?php $__currentLoopData = $halamanKategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $halIdx => $grupKategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($grupKategori->isNotEmpty()): ?>
<div class="page">
    <?php if($bgPageBase64): ?>
        <img src="<?php echo e($bgPageBase64); ?>" class="bg-full">
    <?php endif; ?>

    <div class="content-wrap">
        <?php if($halIdx === 0): ?>
            <div style="text-align:center; font-weight:bold; font-size:14px; margin-bottom:10px;">
                KEGIATAN TAMBAHAN
            </div>
        <?php endif; ?>

        <?php $__currentLoopData = $grupKategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $katIdx => $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $bgKat = $warnaKategori[$katIdx] ?? '#95b3d7';
            ?>

            <div style="font-weight:bold; font-size:11.5px; margin-top:<?php echo e($loop->first ? '2px' : '12px'); ?>; margin-bottom:5px;">
                <?php echo e($katIdx + 1); ?>. &nbsp;<?php echo e(strtoupper($kategori->nama_katagori)); ?>

            </div>

            <table class="table-kegiatan">
                <thead>
                    <tr style="background-color: <?php echo e($bgKat); ?>;">
                        <th rowspan="2" width="8%">NO.</th>
                        <th rowspan="2" width="56%">ASPEK PENILAIAN</th>
                        <th colspan="4" width="36%">TINGKAT PERKEMBANGAN</th>
                    </tr>
                    <tr style="background-color: <?php echo e($bgKat); ?>;">
                        <th width="9%">BB</th>
                        <th width="9%">MB</th>
                        <th width="9%">BSH</th>
                        <th width="9%">BSB</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $kategori->itemKegiatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemIdx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $nilaiKeg = $kegiatan->where('id_item', $item->id_item)->first();
                            $valKeg = $nilaiKeg->nilai ?? '';
                        ?>
                        <tr style="background-color: rgba(255,255,255,0.78);">
                            <td class="center bold"><?php echo e($itemIdx + 1); ?>.</td>
                            <td><?php echo e($item->nama_item); ?></td>
                            <td class="center"><?php echo $valKeg === 'BB' ? '<span class="checkmark">&#10004;</span>' : ''; ?></td>
                            <td class="center"><?php echo $valKeg === 'MB' ? '<span class="checkmark">&#10004;</span>' : ''; ?></td>
                            <td class="center"><?php echo $valKeg === 'BSH' ? '<span class="checkmark">&#10004;</span>' : ''; ?></td>
                            <td class="center"><?php echo $valKeg === 'BSB' ? '<span class="checkmark">&#10004;</span>' : ''; ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="footer-lcpa">
        <?php if($kidsFooter): ?>
            <img src="<?php echo e($kidsFooter); ?>" class="footer-kids">
        <?php endif; ?>
        <div class="footer-pagenum">
            <strong><?php echo e($lcpaPage++); ?></strong> | <span style="letter-spacing:2px; color:#777;">L C P A</span>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




<div class="page">
    <?php if($bgPageBase64): ?>
        <img src="<?php echo e($bgPageBase64); ?>" class="bg-full">
    <?php endif; ?>

    <div class="content-wrap" style="padding-top:16mm;">
        
        <div class="refleksi-wrapper">
            <div class="refleksi-badge-row">
                <span class="refleksi-badge">REFLEKSI GURU</span>
            </div>
            <div class="refleksi-box">
                <p style="margin:0; text-indent:28px;">
                    <?php echo e($refleksiGuru->catatan_guru ?? $refleksiGuru->refleksi ?? '-'); ?>

                </p>
            </div>
        </div>

        
        <div class="refleksi-wrapper" style="margin-top:42px;">
            <div class="refleksi-badge-row">
                <span class="refleksi-badge">REFLEKSI ORANG TUA</span>
            </div>
            <div class="refleksi-box" style="padding-top:26px;">
                <?php for($line = 0; $line < 7; $line++): ?>
                    <div style="border-bottom: 1px dotted #333; height: 22px; margin-bottom: 6px;"></div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <div class="footer-lcpa">
        <?php if($kidsFooter): ?>
            <img src="<?php echo e($kidsFooter); ?>" class="footer-kids">
        <?php endif; ?>
        <div class="footer-pagenum">
            <strong><?php echo e($lcpaPage++); ?></strong> | <span style="letter-spacing:2px; color:#777;">L C P A</span>
        </div>
    </div>
</div>




<div class="page">
    <?php if($bgPageBase64): ?>
        <img src="<?php echo e($bgPageBase64); ?>" class="bg-full">
    <?php endif; ?>

    <div class="content-wrap" style="padding-top:16mm;">
        <div style="
            background-color: #b5d59c;
            padding: 6px 10px;
            font-weight: bold;
            font-size: 11.5px;
            margin-bottom: 8px;
        ">
            PRESENSI
        </div>

        <table style="width:100%; border:none; margin-bottom:18px; font-size:11.5px;">
            <thead>
                <tr>
                    <th style="border:none; width:15%; padding:6px; text-align:center;">NO</th>
                    <th style="border:none; width:55%; padding:6px; text-align:center;">KEHADIRAN</th>
                    <th style="border:none; width:30%; padding:6px; text-align:center;">KET</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color:#f2dcdb;">
                    <td style="border:none; padding:6px; text-align:center;">1.</td>
                    <td style="border:none; padding:6px; text-align:center;">Sakit</td>
                    <td style="border:none; padding:6px; text-align:center;">
                        <?php echo e(($presensi->sakit ?? 0) > 0 ? $presensi->sakit : '-'); ?>

                    </td>
                </tr>
                <tr style="background-color:#ffffff;">
                    <td style="border:none; padding:6px; text-align:center;">2.</td>
                    <td style="border:none; padding:6px; text-align:center;">Izin</td>
                    <td style="border:none; padding:6px; text-align:center;">
                        <?php echo e(($presensi->izin ?? 0) > 0 ? $presensi->izin : '-'); ?>

                    </td>
                </tr>
                <tr style="background-color:#f2dcdb;">
                    <td style="border:none; padding:6px; text-align:center;">3.</td>
                    <td style="border:none; padding:6px; text-align:center;">Tanpa Keterangan</td>
                    <td style="border:none; padding:6px; text-align:center;">
                        <?php echo e(($presensi->alpha ?? 0) > 0 ? $presensi->alpha : '-'); ?>

                    </td>
                </tr>
            </tbody>
        </table>

        <table style="width:100%; border:none; margin-bottom:38px; font-size:11.5px;">
            <thead>
                <tr>
                    <th style="border:none; width:15%; padding:8px 6px; text-align:center;">NO</th>
                    <th style="border:none; width:45%; padding:8px 6px; text-align:center;">PERKEMBANGAN</th>
                    <th style="border:none; width:40%; padding:8px 6px; text-align:center;">PENGUKURAN</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $tb = isset($antropometri->tinggi_badan) ? rtrim(rtrim(number_format((float)$antropometri->tinggi_badan, 2, '.', ''), '0'), '.') . ' Cm' : '-';
                    $bb = isset($antropometri->berat_badan) ? rtrim(rtrim(number_format((float)$antropometri->berat_badan, 2, '.', ''), '0'), '.') . ' Kg' : '-';
                    $lk = isset($antropometri->lingkar_kepala) ? rtrim(rtrim(number_format((float)$antropometri->lingkar_kepala, 2, '.', ''), '0'), '.') . ' Cm' : '-';
                ?>
                <tr style="background-color:#e4efdc;">
                    <td style="border:none; padding:6px; text-align:center;">1</td>
                    <td style="border:none; padding:6px; text-align:center;">Tinggi Badan</td>
                    <td style="border:none; padding:6px; text-align:center;"><?php echo e($tb); ?></td>
                </tr>
                <tr style="background-color:#ffffff;">
                    <td style="border:none; padding:6px; text-align:center;">2</td>
                    <td style="border:none; padding:6px; text-align:center;">Berat Badan</td>
                    <td style="border:none; padding:6px; text-align:center;"><?php echo e($bb); ?></td>
                </tr>
                <tr style="background-color:#e4efdc;">
                    <td style="border:none; padding:6px; text-align:center;">3</td>
                    <td style="border:none; padding:6px; text-align:center;">Lingkar kepala</td>
                    <td style="border:none; padding:6px; text-align:center;"><?php echo e($lk); ?></td>
                </tr>
            </tbody>
        </table>

        
        <table style="width:100%; border:none; font-size:11.5px; margin-top:20px;">
            <tr>
                <td style="border:none; width:48%; text-align:center; vertical-align:top;">
                    <div style="margin-top:14px;">Orang Tua/Wali Siswa</div>
                    <div style="height:56px;"></div>
                    <div>…………………………………….</div>
                </td>
                <td style="border:none; width:4%;"></td>
                <td style="border:none; width:48%; text-align:center; vertical-align:top;">
                    <div>
                        Guru kelas/<br>
                        Wali kelas / <?php echo e($labelKelompok); ?>

                    </div>
                    <div style="height:56px;"></div>
                    <div><?php echo e($siswa->kelas->user->name ?? '…………………………………….'); ?></div>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border:none; text-align:center; padding-top:22px;">
                    <div>Mengetahui</div>
                    <div style="font-weight:bold;">
                        Kepala Sekolah<br>
                        <?php echo e($pengaturan->nama_sekolah ?? 'TK Al-Ikhlas Taliwang'); ?>

                    </div>
                    <div style="height:58px;"></div>
                    <div><?php echo e($pengaturan->kepala_sekolah ?? 'Putri Balqis, S.E'); ?></div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer-lcpa">
        <?php if($kidsFooter): ?>
            <img src="<?php echo e($kidsFooter); ?>" class="footer-kids">
        <?php endif; ?>
        <div class="footer-pagenum">
            <strong><?php echo e($lcpaPage++); ?></strong> | <span style="letter-spacing:2px; color:#777;">L C P A</span>
        </div>
    </div>
</div>

</body>
</html>
<?php /**PATH D:\Projects\siakad-tk-alikhlas\resources\views/guru/raport/pdf.blade.php ENDPATH**/ ?>