<?php $__env->startSection('title', 'Pool Tickets'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .report-page-header {
        background: linear-gradient(135deg, #1c3451 0%, #2a4a6b 100%);
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .report-page-header h6 {
        color: #fff;
        font-size: 18px;
        font-weight: 700;
        margin: 0;
    }

    .report-page-header .header-icon {
        width: 44px;
        height: 44px;
        background: rgba(193,160,103,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 14px;
    }

    .report-page-header .header-icon i {
        color: #c1a067;
        font-size: 18px;
    }

    .report-main-card {
        border: none;
        border-radius: 16px;
        border-top: 3px solid #c1a067 !important;
        box-shadow: 0 4px 20px rgba(28,52,81,0.08);
    }

    .report-main-card .card-body {
        padding: 24px;
    }

    .filter-section {
        background: #f8fafc;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
        border: 1px solid #e8edf2;
    }

    .filter-section .form-control,
    .filter-section .form-select {
        border-radius: 10px;
        border: 1px solid #dde2e8;
        font-size: 13px;
        padding: 8px 13px;
        color: #1c3451;
    }

    .filter-section .form-control:focus,
    .filter-section .form-select:focus {
        border-color: #c1a067;
        box-shadow: 0 0 0 3px rgba(193,160,103,0.15);
    }

    .report-table thead th {
        background: #1c3451;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 12px 14px;
        border: none;
    }

    .report-table thead th:first-child { border-radius: 10px 0 0 0; }
    .report-table thead th:last-child  { border-radius: 0 10px 0 0; }

    .report-table tbody tr { transition: background 0.15s; }
    .report-table tbody tr:hover { background: #f8fafc; }

    .report-table tbody td {
        font-size: 13px;
        color: #374151;
        padding: 12px 14px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .report-table tbody td.fw-bold { color: #1c3451; }

    .btn-view {
        background: #1c3451;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        transition: all 0.2s;
    }

    .btn-view:hover { background: #c1a067; color: #fff; }

    .btn-verify {
        background: #15803d;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        transition: all 0.2s;
    }

    .btn-verify:hover { background: #16a34a; color: #fff; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="report-page-header">
    <div class="d-flex align-items-center">
        <div class="header-icon">
            <i class="fas fa-ticket-alt"></i>
        </div>
        <h6>Daftar Tiket Kolam</h6>
    </div>
</div>

<div class="card report-main-card">
    <div class="card-body">

        <div class="filter-section">
            <div class="row g-2">
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter" onchange="filterTickets()">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="used">Digunakan</option>
                        <option value="expired">Kadaluarsa</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="paymentFilter" onchange="filterTickets()">
                        <option value="">Semua Pembayaran</option>
                        <option value="paid">Lunas</option>
                        <option value="unpaid">Belum Bayar</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="searchFilter" placeholder="Cari nama atau kode tiket..." onkeyup="filterTickets()">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table report-table" id="ticketsTable">
                <thead>
                    <tr>
                        <th>Kode Tiket</th>
                        <th>Customer</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Jenis Tiket</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-bold"><?php echo e($ticket->ticket_code); ?></td>
                        <td>
                            <?php echo e($ticket->customer_name); ?><br>
                            <small class="text-muted"><?php echo e($ticket->customer_phone); ?></small>
                        </td>
                        <td>
                            <?php echo e(\Carbon\Carbon::parse($ticket->visit_date)->format('d M Y')); ?><br>
                            <small class="text-muted"><?php echo e($ticket->visit_time ?? 'Fleksibel'); ?></small>
                        </td>
                        <td>
                            <?php if($ticket->ticket_type == 'adult'): ?>
                                <span class="badge bg-primary">Dewasa</span>
                            <?php elseif($ticket->ticket_type == 'child'): ?>
                                <span class="badge bg-info">Anak</span>
                            <?php else: ?>
                                <span class="badge bg-success">Keluarga</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center"><?php echo e($ticket->number_of_tickets); ?> tiket</td>
                        <td>Rp <?php echo e(number_format($ticket->total_amount, 0, ',', '.')); ?></td>
                        <td>
                            <?php echo $ticket->status_label; ?><br>
                            <small><?php echo $ticket->payment_status_label; ?></small>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.tickets.show', $ticket)); ?>" class="btn btn-view">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if($ticket->status == 'active' && $ticket->payment_status == 'paid'): ?>
                                <button onclick="verifyTicket(<?php echo e($ticket->id); ?>)" class="btn btn-verify ms-1">
                                    <i class="fas fa-check"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Belum ada data tiket kolam</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($tickets->links()); ?>

        </div>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function verifyTicket(id) {
        if(confirm('Tandai tiket ini sebagai sudah digunakan?')) {
            fetch(`/admin/tickets/${id}/verify`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json()).then(data => {
                if(data.success) location.reload();
            });
        }
    }

    function filterTickets() {
        const status  = document.getElementById('statusFilter').value;
        const payment = document.getElementById('paymentFilter').value;
        const search  = document.getElementById('searchFilter').value.toLowerCase();
        const rows    = document.querySelectorAll('#ticketsTable tbody tr');

        rows.forEach(row => {
            let show = true;
            if (status) {
                const statusCell = row.cells[6]?.innerText.toLowerCase();
                if (!statusCell || !statusCell.includes(status)) show = false;
            }
            if (payment && show) {
                const paymentCell = row.cells[6]?.innerHTML.toLowerCase();
                if (!paymentCell || !paymentCell.includes(payment)) show = false;
            }
            if (search && show) {
                const text = row.innerText.toLowerCase();
                if (!text.includes(search)) show = false;
            }
            row.style.display = show ? '' : 'none';
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/admin/tickets/index.blade.php ENDPATH**/ ?>