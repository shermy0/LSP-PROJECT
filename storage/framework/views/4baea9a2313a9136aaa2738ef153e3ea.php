<?php $__env->startSection('title', 'FR.APL.01 - Permohonan Sertifikasi Kompetensi'); ?>

<?php $__env->startSection('konten'); ?>
    <div class="container mt-2 my-5">
        <div class="bg-white border rounded-3 shadow-sm p-4">

            <!-- Header -->
            <div class="mb-4">
                <p class="small text-muted mb-1">Form Asesmen &gt; <span class="fw-semibold">FR.APL.01</span></p>
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="rounded mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
                    <h1 class="h5 fw-bold">Permohonan Sertifikasi Kompetensi</h1>
                    <span class="badge bg-light text-dark mt-2 px-3 py-2 rounded-pill">
                        Rincian Data Pemohon Sertifikasi
                    </span>
                </div>
            </div>

            <!-- Form -->
            <form id="formApl01" action="<?php echo e(route('asesi.permohonan.store')); ?>" method="POST" novalidate>
                <?php echo csrf_field(); ?>

                <!-- Data Pribadi -->
                <div class="border rounded-3 p-3 mb-4">
                    <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                        <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start"
                              style="width:8px;"></span>
                        &nbsp;&nbsp;Data Pribadi
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <?php if(!empty($asesi->nama_lengkap)): ?>
                            <input type="text" class="form-control rounded-3" value="<?php echo e($asesi->nama_lengkap); ?>" readonly>
                            <input type="hidden" name="nama_lengkap" value="<?php echo e($asesi->nama_lengkap); ?>">
                        <?php else: ?>
                            <input type="text" name="nama_lengkap" class="form-control rounded-3 required-field"
                                   placeholder="Masukkan nama" value="<?php echo e(old('nama_lengkap')); ?>" required>
                            <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
                        <?php endif; ?>
                    </div>

                    <!-- NIK -->
                    <div class="mb-3">
                        <label class="form-label">No. KTP/NIK/Paspor <span class="text-danger">*</span></label>
                        <?php if(!empty($asesi->nik)): ?>
                            <input type="text" class="form-control rounded-3" value="<?php echo e($asesi->nik); ?>" readonly>
                            <input type="hidden" name="nik" value="<?php echo e($asesi->nik); ?>">
                        <?php else: ?>
                            <input type="text" name="nik" class="form-control rounded-3 required-field"
                                   placeholder="Masukkan nomor identitas" value="<?php echo e(old('nik')); ?>" required>
                            <div class="invalid-feedback">Nomor identitas wajib diisi.</div>
                        <?php endif; ?>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <?php if(!empty($asesi->tgl_lahir)): ?>
                            <input type="date" class="form-control rounded-3" value="<?php echo e($asesi->tgl_lahir); ?>" readonly>
                            <input type="hidden" name="tgl_lahir" value="<?php echo e($asesi->tgl_lahir); ?>">
                        <?php else: ?>
                            <input type="date" name="tgl_lahir" class="form-control rounded-3 required-field"
                                   value="<?php echo e(old('tgl_lahir')); ?>" required>
                            <div class="invalid-feedback">Tanggal lahir wajib diisi.</div>
                        <?php endif; ?>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <?php if(!empty($asesi->jenis_kelamin)): ?>
                            <input type="text" class="form-control rounded-3"
                                   value="<?php echo e($asesi->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'); ?>" readonly>
                            <input type="hidden" name="jenis_kelamin" value="<?php echo e($asesi->jenis_kelamin); ?>">
                        <?php else: ?>
                            <select name="jenis_kelamin" class="form-select rounded-3 required-field" required>
                                <option value="">Pilih</option>
                                <option value="L" <?php echo e(old('jenis_kelamin')=='L' ? 'selected' : ''); ?>>Laki-laki</option>
                                <option value="P" <?php echo e(old('jenis_kelamin')=='P' ? 'selected' : ''); ?>>Perempuan</option>
                            </select>
                            <div class="invalid-feedback">Jenis kelamin wajib dipilih.</div>
                        <?php endif; ?>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label class="form-label">Alamat Rumah <span class="text-danger">*</span></label>
                        <?php if(!empty($asesi->alamat)): ?>
                            <input type="text" class="form-control rounded-3" value="<?php echo e($asesi->alamat); ?>" readonly>
                            <input type="hidden" name="alamat" value="<?php echo e($asesi->alamat); ?>">
                        <?php else: ?>
                            <input type="text" name="alamat" class="form-control rounded-3 required-field"
                                   placeholder="Masukkan alamat" value="<?php echo e(old('alamat')); ?>" required>
                            <div class="invalid-feedback">Alamat wajib diisi.</div>
                        <?php endif; ?>
                    </div>

                    <!-- Telepon -->
                    <div class="mb-3">
                        <label class="form-label">No Telepon <span class="text-danger">*</span></label>
                        <?php if(!empty($asesi->telepon)): ?>
                            <input type="text" class="form-control rounded-3" value="<?php echo e($asesi->telepon); ?>" readonly>
                            <input type="hidden" name="telepon" value="<?php echo e($asesi->telepon); ?>">
                        <?php else: ?>
                            <input type="text" name="telepon" class="form-control rounded-3 required-field"
                                   placeholder="Masukkan nomor telepon" value="<?php echo e(old('telepon')); ?>" required>
                            <div class="invalid-feedback">Nomor telepon wajib diisi.</div>
                        <?php endif; ?>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <?php if(!empty($asesi->email)): ?>
                            <input type="email" class="form-control rounded-3" value="<?php echo e($asesi->email); ?>" readonly>
                            <input type="hidden" name="email" value="<?php echo e($asesi->email); ?>">
                        <?php else: ?>
                            <input type="email" name="email" class="form-control rounded-3 required-field"
                                   placeholder="Masukkan email" value="<?php echo e(old('email', auth()->user()->email ?? '')); ?>" required>
                            <div class="invalid-feedback">Email wajib diisi.</div>
                        <?php endif; ?>
                    </div>

                    <!-- Pendidikan -->
                    <div class="mb-3">
                        <label class="form-label">Kualifikasi Pendidikan <span class="text-danger">*</span></label>
                        <?php if(!empty($asesi->pendidikan_terakhir)): ?>
                            <input type="text" class="form-control rounded-3" value="<?php echo e($asesi->pendidikan_terakhir); ?>" readonly>
                            <input type="hidden" name="pendidikan_terakhir" value="<?php echo e($asesi->pendidikan_terakhir); ?>">
                        <?php else: ?>
                            <input type="text" name="pendidikan_terakhir" class="form-control rounded-3 required-field"
                                   placeholder="Masukkan pendidikan terakhir" value="<?php echo e(old('pendidikan_terakhir')); ?>" required>
                            <div class="invalid-feedback">Pendidikan terakhir wajib diisi.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Data Pekerjaan (ambil dari TUK) -->
                <div class="border rounded-3 p-3 mb-4">
                    <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                        <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                        &nbsp;&nbsp;Data Pekerjaan
                    </div>
                    <div class="px-2">
                        <p><strong>Nama Sekolah</strong> : <?php echo e($tuk->nama_tuk); ?></p>
                        <p><strong>Jabatan</strong> : <?php echo e($tuk->jabatan); ?></p>
                        <p><strong>Alamat</strong> : <?php echo e($tuk->alamat_tuk); ?></p>
                        <p><strong>Telepon</strong> : <a href="tel:<?php echo e($tuk->telepon); ?>" class="text-primary"><?php echo e($tuk->telepon); ?></a></p>
                        <p><strong>Fax</strong> : <?php echo e($tuk->fax ?? '-'); ?></p>
                        <p><strong>Email</strong> : <?php echo e($tuk->email); ?></p>
                    </div>
                </div>

                <!-- Button -->
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn" style="background-color:#041562; color:#fff;">Selanjutnya</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Validasi -->
    <script>
        document.getElementById('formApl01').addEventListener('submit', function (e) {
            let valid = true;
            let firstInvalid = null;

            this.querySelectorAll('.required-field').forEach(field => {
                if (!field.value) {
                    field.classList.add('is-invalid');
                    valid = false;
                    if (!firstInvalid) firstInvalid = field;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!valid) {
                e.preventDefault();
                firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
                firstInvalid.focus();
            }
        });

        // hilangkan merah saat user isi field
        document.querySelectorAll('.required-field').forEach(field => {
            field.addEventListener('input', function () {
                if (this.value) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LSP-PROJECT\resources\views/asesi/permohonan/form1.blade.php ENDPATH**/ ?>