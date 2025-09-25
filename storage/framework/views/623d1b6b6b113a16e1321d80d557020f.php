<!DOCTYPE html>
<html>
<head>
    <title>Register Asesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/register.css')); ?>">
</head>
<body>

<div class="register-card">
    <h2 class="text-center">Form Pendaftaran Asesi</h2>

    <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <form action="<?php echo e(route('register.asesi.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <h5>Akun Login</h5>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
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
            <div class="col-md-6 mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
                <small id="confirmError" class="text-danger"></small> <!-- tempat error -->
            </div>
        </div>


        <hr>
        <h5>Data Asesi</h5>
        <div class="mb-3">
            <label>NIK</label>
        <input type="text" name="nik" class="form-control" pattern="\d{16}" title="NIK harus 16 digit angka" required>
        </div>
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Telepon</label>
            <input type="text" name="telepon" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-3">Daftar</button>
    </form>

        <div class="mt-4 text-center">
        <p class="text-sm">
            Sudah punya akun?
            <a href="<?php echo e(route('login')); ?>" class="text-blue-500 hover:underline">
                Login
            </a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelector("form").addEventListener("submit", function(event) {
    let password = document.querySelector("input[name='password']").value;
    let confirm = document.querySelector("input[name='password_confirmation']").value;

    if (password !== confirm) {
        event.preventDefault(); // stop form submit
        alert("Password dan Konfirmasi Password tidak sama!");
    }
});
</script>
</body>
</html>
<?php /**PATH C:\laragon\www\LSP-PROJECT\resources\views/auth/register_asesi.blade.php ENDPATH**/ ?>