<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startPush('styles'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Reservations</p>
              <h5 class="font-weight-bolder mb-0">
                <?php echo e($stats['today_reservations']); ?>

              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
              <i class="fas fa-calendar-alt text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Tickets</p>
              <h5 class="font-weight-bolder mb-0">
                <?php echo e($stats['today_tickets']); ?>

              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
              <i class="fas fa-ticket-alt text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Income</p>
              <h5 class="font-weight-bolder mb-0">
                Rp <?php echo e(number_format($stats['today_income'], 0, ',', '.')); ?>

              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
              <i class="fas fa-money-bill-wave text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-xl-3 col-sm-6">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Pending Reservations</p>
              <h5 class="font-weight-bolder mb-0">
                <?php echo e($stats['pending_reservations']); ?>

              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
              <i class="fas fa-clock text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4">
  <div class="col-lg-7 mb-lg-0 mb-4">
    <div class="card z-index-2">
      <div class="card-header pb-0">
        <h6>Weekly Overview</h6>
        <p class="text-sm">
          <i class="fa fa-arrow-up text-success"></i>
          <span class="font-weight-bold">4% more</span> than last week
        </p>
      </div>
      <div class="card-body p-3">
        <div class="chart">
          <canvas id="weekly-chart" class="chart-canvas" height="300"></canvas>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header pb-0">
        <h6>Quick Stats</h6>
        <p class="text-sm">System overview</p>
      </div>
      <div class="card-body p-3">
        <div class="list-group">
          <div class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
            <div class="d-flex align-items-center">
              <div class="icon icon-shape icon-sm me-3 bg-gradient-primary shadow text-center">
                <i class="fas fa-utensils text-white opacity-10"></i>
              </div>
              <div class="d-flex flex-column">
                <h6 class="mb-1 text-dark text-sm">Total Menus</h6>
              </div>
            </div>
            <div class="d-flex">
              <h4 class="mb-0 font-weight-bolder"><?php echo e(\App\Models\Menu::count()); ?></h4>
            </div>
          </div>
          
          <div class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
            <div class="d-flex align-items-center">
              <div class="icon icon-shape icon-sm me-3 bg-gradient-success shadow text-center">
                <i class="fas fa-tags text-white opacity-10"></i>
              </div>
              <div class="d-flex flex-column">
                <h6 class="mb-1 text-dark text-sm">Active Promos</h6>
              </div>
            </div>
            <div class="d-flex">
              <h4 class="mb-0 font-weight-bolder"><?php echo e(\App\Models\Promo::active()->count()); ?></h4>
            </div>
          </div>
          
          <div class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
            <div class="d-flex align-items-center">
              <div class="icon icon-shape icon-sm me-3 bg-gradient-info shadow text-center">
                <i class="fas fa-star text-white opacity-10"></i>
              </div>
              <div class="d-flex flex-column">
                <h6 class="mb-1 text-dark text-sm">Pending Testimonials</h6>
              </div>
            </div>
            <div class="d-flex">
              <h4 class="mb-0 font-weight-bolder"><?php echo e($stats['pending_testimonials']); ?></h4>
            </div>
          </div>
          
          <div class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
            <div class="d-flex align-items-center">
              <div class="icon icon-shape icon-sm me-3 bg-gradient-warning shadow text-center">
                <i class="fas fa-images text-white opacity-10"></i>
              </div>
              <div class="d-flex flex-column">
                <h6 class="mb-1 text-dark text-sm">Gallery Items</h6>
              </div>
            </div>
            <div class="d-flex">
              <h4 class="mb-0 font-weight-bolder"><?php echo e(\App\Models\Gallery::count()); ?></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Recent Reservations</h6>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Booking Code</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Guests</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = \App\Models\TableReservation::latest()->take(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm"><?php echo e($reservation->booking_code); ?></h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0"><?php echo e($reservation->customer_name); ?></p>
                  <p class="text-xs text-secondary mb-0"><?php echo e($reservation->customer_phone); ?></p>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo e($reservation->reservation_date->format('d M Y')); ?></span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo e($reservation->number_of_guests); ?></span>
                </td>
                <td class="align-middle text-center text-sm">
                  <?php echo $reservation->status_label; ?>

                </td>
                <td class="align-middle">
                  <a href="<?php echo e(route('admin.reservations.show', $reservation)); ?>" class="btn btn-link text-dark px-3 mb-0">
                    <i class="fas fa-eye text-dark me-2" aria-hidden="true"></i> View
                  </a>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  var ctx = document.getElementById("weekly-chart").getContext("2d");
  
  new Chart(ctx, {
    type: "line",
    data: {
      labels: <?php echo json_encode(array_column($chartData, 'date')); ?>,
      datasets: [{
        label: "Reservations",
        data: <?php echo json_encode(array_column($chartData, 'reservations')); ?>,
        borderColor: "#cb0c9f",
        borderWidth: 3,
        backgroundColor: "rgba(203,12,159,0.1)",
        fill: true,
        tension: 0.4
      }, {
        label: "Tickets",
        data: <?php echo json_encode(array_column($chartData, 'tickets')); ?>,
        borderColor: "#3A416F",
        borderWidth: 3,
        backgroundColor: "rgba(58,65,111,0.1)",
        fill: true,
        tension: 0.4
      }, {
        label: "Income (Rp) / 1000",
        data: <?php echo json_encode(array_map(function($item) { return $item['income'] / 1000; }, $chartData)); ?>,
        borderColor: "#ff9800",
        borderWidth: 3,
        backgroundColor: "rgba(255,152,0,0.1)",
        fill: true,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: false,
            borderDash: [5, 5]
          }
        },
        x: {
          grid: {
            drawBorder: false,
            display: false,
            drawOnChartArea: false,
            drawTicks: false
          }
        }
      }
    }
  });
</script>
<?php $__env->stopPush(); ?>    
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>