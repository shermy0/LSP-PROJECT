<?php $__env->startSection('title', 'Dashboard Asesor'); ?>

<?php $__env->startSection('konten'); ?>
<h2 class="fw-bold mb-2">Dashboard Asesor</h2>
<p class="text-muted mb-4">Kelola asesmen dengan standar profesional terdepan</p>


<div class="row g-4">
  <?php
  $stats = [
    ['icon'=>'fa-chart-bar','color'=>'#3498db','label'=>'Total Peserta','value'=>$totalPeserta],
    ['icon'=>'fa-certificate','color'=>'#2ecc71','label'=>'Sertifikat','value'=>$totalSertifikat],
    ['icon'=>'fa-spinner','color'=>'#f1c40f','label'=>'Dalam Progres','value'=>$dalamProgres],
    ['icon'=>'fa-award','color'=>'#9b59b6','label'=>'Penghargaan','value'=>$penghargaan],
  ];
?>


  <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <div class="col-md-3">
    <div class="card shadow-sm border-0 text-center p-4 rounded-4" style="background:#fff;">
      <div class="d-flex justify-content-center align-items-center mb-3"
           style="width:60px;height:60px;border-radius:16px;background:<?php echo e($item['color']); ?>15;">
        <i class="fas <?php echo e($item['icon']); ?> fa-lg" style="color:<?php echo e($item['color']); ?>"></i>
      </div>
      <h4 class="fw-bold mb-0"><?php echo e($item['value']); ?></h4>
      <p class="mb-1"><?php echo e($item['label']); ?></p>
      <div class="badge bg-light text-dark px-3 py-2" style="font-size:12px;">
        <span style="color:<?php echo e($item['color']); ?>">12.5% Growth</span> <br> This Month
      </div>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="card shadow-sm border-0 mt-5 p-4 rounded-4" style="background:#fff;">
  <h5 class="fw-bold mb-3">Grafik Sertifikasi</h5>
  <div style="height:350px;">
    <canvas id="sertifikasiChart"></canvas>
  </div>
<div class="d-flex justify-content-between mt-3 text-muted">
  <div><span class="fw-bold text-primary"><?php echo e($totalSertifikat); ?></span> Total Tersertifikasi</div>
  <div><span class="fw-bold text-success">18%</span> Rata-rata Pertumbuhan</div>
  <div>
    <span class="fw-bold" style="color:<?php echo e($topColor); ?>">
      <?php echo e($topJurusan); ?>

    </span> Jurusan Terbanyak Sertifikasi
  </div>
</div>
</div>
<?php $__env->stopSection(); ?>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const ctx = document.getElementById('sertifikasiChart').getContext('2d');

  // Warna dasar
  const baseColors = ["#f1c40f","#3498db","#e74c3c","#e67e22","#9b59b6","#2ecc71","#7f8c8d"];
  const gradients = baseColors.map(color => {
    let g = ctx.createLinearGradient(0, 0, 0, 350);
    g.addColorStop(0, color);
    g.addColorStop(1, color + "33"); // versi transparan
    return g;
  });

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($labels, 15, 512) ?>,
      datasets: [{
        label: 'Total Sertifikasi',
        data: <?php echo json_encode($values, 15, 512) ?>,
        backgroundColor: gradients.slice(0, <?php echo json_encode(count($labels), 15, 512) ?>),
        borderRadius: 30,
        barThickness:90
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 20,
            callback: value => value + ' peserta'
          },
          grid: { color: '#eee' }
        },
        x: {
          grid: { display: false }
        }
      }
    }
  });
});
</script>
<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LSP-PROJECT\resources\views/asesor/dashboard.blade.php ENDPATH**/ ?>