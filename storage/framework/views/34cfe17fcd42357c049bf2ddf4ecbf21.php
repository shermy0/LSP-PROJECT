<?php $__env->startSection('title', 'Asesmen Mandiri'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span>Form Asesmen &gt; <strong>FR.APL.02</strong></span>
    </div>

    <!-- Logo -->
    <div class="logo-box">
        <div class="logo"></div>
        <h2>Asesmen Mandiri</h2>
    </div>

    <!-- Form -->
    <div class="form-wrapper">
        <div class="form-box">
            <label for="judul">Judul</label>
            <select id="judul">
                <option>Pilih Judul</option>
                <option>Desain Multimedia</option>
                <option>Pengembangan Web</option>
            </select>
            <div class="error-message"></div>
        </div>

        <div class="form-box">
            <label for="nomor">Nomor</label>
            <input type="text" id="nomor" placeholder="Masukkan Nomor">
        </div>

        <div class="form-box">
            <label for="skema">Skema Sertifikasi</label>
            <select id="skema">
                <option>Pilih Skema</option>
                <option>Multimedia</option>
                <option>Web Development</option>
            </select>
            <div class="error-message"></div>
        </div>
    </div>

    <!-- Panduan -->
    <div class="guide-box">
        <div class="guide-header">
            <h3>Panduan Asesmen Mandiri</h3>
        </div>

        <div class="step">
            <div class="step-number">1.</div>
            <div class="step-text">Baca setiap pertanyaan/kriteria yang ditampilkan.</div>
        </div>

        <div class="step">
            <div class="step-number">2.</div>
            <div class="step-text">Pilih opsi "Kompeten" atau "Belum Kompeten" sesuai keyakinan Anda.</div>
        </div>

        <div class="step">
            <div class="step-number">3.</div>
            <div class="step-text">Jika Anda memilih "Kompeten", silakan unggah bukti pendukung (file atau deskripsi singkat).</div>
        </div>

        <div class="step">
            <div class="step-number">4.</div>
            <div class="step-text">Pastikan semua pertanyaan sudah diisi sebelum mengirimkan asesmen mandiri.</div>
        </div>
    </div>

    <!-- Tombol -->
    <div class="button-box">
        <a href="<?php echo e(route('asesmen')); ?>" class="btn-next" id="btnNext">Selanjutnya</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LSP-PROJECT\resources\views/asesi/index.blade.php ENDPATH**/ ?>