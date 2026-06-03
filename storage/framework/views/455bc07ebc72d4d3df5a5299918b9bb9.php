<?php $__env->startSection('title', 'Detail Tiket'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-transparent text-center pt-4">
                    <h4 class="fw-bold mb-2">Detail Tiket Kolam</h4>
                    <p class="text-muted">Kode Tiket: <strong><?php echo e($ticket->ticket_code); ?></strong></p>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <?php if($ticket->status == 'active'): ?>
                            <span class="badge bg-success px-3 py-2">Aktif</span>
                        <?php elseif($ticket->status == 'used'): ?>
                            <span class="badge bg-secondary px-3 py-2">Sudah Digunakan</span>
                        <?php else: ?>
                            <span class="badge bg-danger px-3 py-2">Kadaluarsa</span>
                        <?php endif; ?>
                        
                        <?php if($ticket->payment_status == 'paid'): ?>
                            <span class="badge bg-success px-3 py-2 ms-2">Lunas</span>
                        <?php else: ?>
                            <span class="badge bg-warning px-3 py-2 ms-2">Belum Bayar</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold">Informasi Customer</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 100px;">Nama</th>
                                    <td><?php echo e($ticket->customer_name); ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo e($ticket->customer_email); ?></td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td><?php echo e($ticket->customer_phone); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold">Informasi Tiket</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 100px;">Tanggal</th>
                                    <td><?php echo e(\Carbon\Carbon::parse($ticket->visit_date)->format('d F Y')); ?></td>
                                </tr>
                                <tr>
                                    <th>Jenis Tiket</th>
                                    <td><?php echo e(ucfirst($ticket->ticket_type)); ?></td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td><?php echo e($ticket->number_of_tickets); ?> tiket</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>Rp <?php echo e(number_format($ticket->total_amount, 0, ',', '.')); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <?php if($ticket->status == 'active' && $ticket->payment_status == 'paid'): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        Tiket Anda siap digunakan. Tunjukkan kode ini saat masuk ke area kolam renang.
                    </div>
                    <?php elseif($ticket->payment_status == 'unpaid'): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Silakan lakukan pembayaran untuk mengaktifkan tiket Anda.
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                            <i class="fas fa-upload me-2"></i> Upload Bukti Pembayaran
                        </button>
                    </div>
                    <?php endif; ?>
                    
                    <div class="text-center mt-4">
                        <a href="<?php echo e(route('branding.home')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Pembayaran -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('reservation.payment.upload')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="booking_code" value="<?php echo e($ticket->ticket_code); ?>">
                <input type="hidden" name="amount" value="<?php echo e($ticket->total_amount); ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="transfer">Transfer Bank</option>
                            <option value="credit_card">Kartu Kredit</option>
                            <option value="e_wallet">E-Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Bukti</label>
                        <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG, PDF. Max 2MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/reservation/ticket/view.blade.php ENDPATH**/ ?>