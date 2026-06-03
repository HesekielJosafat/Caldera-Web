<?php $__env->startSection('title', 'Pembelian Tiket Berhasil - Caldera'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm caldera-card">
                <div class="card-body p-5">
                    <!-- Success Animation -->
                    <div class="text-center mb-4">
                        <div class="success-icon mb-3">
                            <i class="fas fa-check-circle fa-5x" style="color: #25D366;"></i>
                        </div>
                        <h2 class="fw-bold mb-2" style="color: #1c3451; font-family: 'Playfair Display', serif;">Pembelian Tiket Berhasil!</h2>
                        <div class="section-divider mx-auto"></div>
                        <p class="text-muted">Terima kasih telah membeli tiket kolam renang Caldera.</p>
                    </div>
                    
                    <!-- Ticket Code -->
                    <div class="ticket-code-section text-center mb-4">
                        <div class="ticket-code-box">
                            <small class="text-muted text-uppercase fw-semibold d-block mb-1">Kode Tiket Anda</small>
                            <h3 class="fw-bold mb-0" style="color: #1c3451; letter-spacing: 2px;">
                                <i class="fas fa-qrcode me-2" style="color: #c1a067;"></i>
                                <?php echo e($ticket->ticket_code); ?>

                            </h3>
                        </div>
                    </div>
                    
                    <!-- Ticket Details -->
                    <div class="info-section mb-4">
                        <h5 class="fw-bold mb-3" style="color: #1c3451;">
                            <i class="fas fa-ticket-alt me-2" style="color: #c1a067;"></i> Detail Tiket
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3" style="background: #f8f6f2;">
                                    <small class="text-muted d-block mb-1">Nama Customer</small>
                                    <p class="fw-bold mb-0" style="color: #1c3451;">
                                        <i class="fas fa-user me-1" style="color: #c1a067;"></i>
                                        <?php echo e($ticket->customer_name); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3" style="background: #f8f6f2;">
                                    <small class="text-muted d-block mb-1">Tanggal Kunjungan</small>
                                    <p class="fw-bold mb-0" style="color: #1c3451;">
                                        <i class="fas fa-calendar-day me-1" style="color: #c1a067;"></i>
                                        <?php echo e(\Carbon\Carbon::parse($ticket->visit_date)->format('d F Y')); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3" style="background: #f8f6f2;">
                                    <small class="text-muted d-block mb-1">Jenis Tiket</small>
                                    <p class="fw-bold mb-0" style="color: #1c3451;">
                                        <i class="fas fa-tag me-1" style="color: #c1a067;"></i>
                                        <?php
                                            $ticketTypeLabels = [
                                                'adult' => 'Dewasa',
                                                'child' => 'Anak-anak',
                                                'family' => 'Keluarga'
                                            ];
                                        ?>
                                        <?php echo e($ticketTypeLabels[$ticket->ticket_type] ?? ucfirst($ticket->ticket_type)); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3" style="background: #f8f6f2;">
                                    <small class="text-muted d-block mb-1">Jumlah Tiket</small>
                                    <p class="fw-bold mb-0" style="color: #1c3451;">
                                        <i class="fas fa-shopping-cart me-1" style="color: #c1a067;"></i>
                                        <?php echo e($ticket->number_of_tickets); ?> tiket
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="info-card p-3 rounded-3" style="background: #f8f6f2;">
                                    <small class="text-muted d-block mb-1">Total Pembayaran</small>
                                    <p class="fw-bold mb-0" style="color: #c1a067; font-size: 1.2rem;">
                                        <i class="fas fa-money-bill me-1"></i>
                                        Rp <?php echo e(number_format($ticket->total_amount, 0, ',', '.')); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Information -->
                    <div class="alert-custom mb-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-credit-card fa-lg me-3" style="color: #c1a067;"></i>
                            <div>
                                <strong class="small" style="color: #1c3451;">Informasi Pembayaran:</strong>
                                <p class="mb-1 small text-muted">Silakan lakukan pembayaran ke rekening berikut:</p>
                                <div class="mt-2">
                                    <div class="bank-detail mb-2">
                                        <span class="fw-semibold" style="color: #1c3451;">BCA</span>
                                        <span class="text-muted mx-2">|</span>
                                        <span>1234567890</span>
                                        <span class="text-muted mx-2">|</span>
                                        <small>a.n. Caldera Resto</small>
                                    </div>
                                    <div class="bank-detail">
                                        <span class="fw-semibold" style="color: #1c3451;">Mandiri</span>
                                        <span class="text-muted mx-2">|</span>
                                        <span>0987654321</span>
                                        <span class="text-muted mx-2">|</span>
                                        <small>a.n. Caldera Resto</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 justify-content-center mt-4">
                        <button type="button" class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#paymentModal">
                            <i class="fas fa-upload me-2"></i> Upload Bukti Bayar
                        </button>
                        <a href="<?php echo e(route('customer.tickets')); ?>" class="btn btn-outline-custom">
                            <i class="fas fa-ticket-alt me-2"></i> Lihat Tiket Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Pembayaran -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" style="color: #1c3451;">
                    <i class="fas fa-upload me-2" style="color: #c1a067;"></i>
                    Upload Bukti Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('reservation.ticket.payment.upload')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="ticket_code" value="<?php echo e($ticket->ticket_code); ?>">
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color: #1c3451;">Kode Tiket</label>
                        <input type="text" class="form-control caldera-input" value="<?php echo e($ticket->ticket_code); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color: #1c3451;">Total Pembayaran</label>
                        <input type="text" class="form-control caldera-input" value="Rp <?php echo e(number_format($ticket->total_amount, 0, ',', '.')); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color: #1c3451;">Bank Asal Transfer</label>
                        <select name="bank_from" class="form-control caldera-input" required>
                            <option value="">Pilih Bank</option>
                            <option value="BCA">BCA</option>
                            <option value="MANDIRI">MANDIRI</option>
                            <option value="BRI">BRI</option>
                            <option value="BNI">BNI</option>
                            <option value="CIMB">CIMB Niaga</option>
                            <option value="DANAMON">Danamon</option>
                            <option value="PERMATA">Permata</option>
                            <option value="SEABANK">SeaBank</option>
                            <option value="JAGO">Bank Jago</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color: #1c3451;">Nama Pemilik Rekening</label>
                        <input type="text" name="account_name" class="form-control caldera-input" placeholder="Contoh: JOHN DOE" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color: #1c3451;">Upload Bukti Transfer</label>
                        <input type="file" name="payment_proof" class="form-control caldera-input" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG (Max 2MB)</small>
                    </div>
                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle me-2"></i>
                        Setelah upload bukti, admin akan memverifikasi pembayaran Anda.
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-modal-close" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Tutup
                    </button>
                    <button type="submit" class="btn btn-upload-modal">
                        <i class="fas fa-cloud-upload-alt me-2"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap');

    .caldera-card {
        border-radius: 20px !important;
        overflow: hidden;
        transition: transform 0.25s, box-shadow 0.25s;
        border-top: 3px solid #c1a067 !important;
    }

    .caldera-card:hover {
        box-shadow: 0 12px 28px rgba(28,52,81,0.12) !important;
    }

    .section-divider {
        width: 50px;
        height: 3px;
        background: #c1a067;
        margin: 12px auto 16px;
        border-radius: 2px;
    }

    .success-icon {
        animation: scaleIn 0.5s ease;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .ticket-code-box {
        background: linear-gradient(135deg, #f8f6f2, #f0ebe0);
        padding: 15px 25px;
        border-radius: 50px;
        display: inline-block;
        border: 1px solid #e8e0d0;
    }

    .info-card {
        transition: all 0.2s;
        border: 1px solid #e8e0d0;
    }

    .info-card:hover {
        border-color: #c1a067;
        transform: translateY(-2px);
    }

    .alert-custom {
        background: #fdfcfa;
        border-left: 4px solid #c1a067;
        padding: 16px 20px;
        border-radius: 12px;
    }

    .bank-detail {
        background: white;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #e8e0d0;
    }

    /* Buttons */
    .btn-upload {
        background: linear-gradient(135deg, #c1a067, #a8894f);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-upload:hover {
        background: linear-gradient(135deg, #a8894f, #8b6d3f);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(193,160,103,0.3);
    }

    .btn-outline-custom {
        background: white;
        color: #1c3451;
        border: 1.5px solid #1c3451;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-outline-custom:hover {
        background: #1c3451;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(28,52,81,0.2);
    }

    .caldera-input {
        border: 1.5px solid #e8e0d0;
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 14px;
        transition: all 0.2s;
        background: #fff;
    }

    .caldera-input:focus {
        border-color: #c1a067;
        box-shadow: 0 0 0 3px rgba(193,160,103,0.1);
        outline: none;
    }

    .caldera-input[readonly] {
        background: #f8f6f2;
        color: #1c3451;
    }

    .btn-modal-close {
        background: #f1f5f9;
        color: #1c3451;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.2s;
    }

    .btn-modal-close:hover {
        background: #e2e8f0;
        color: #1c3451;
    }

    .btn-upload-modal {
        background: linear-gradient(135deg, #1c3451, #01516e);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.2s;
    }

    .btn-upload-modal:hover {
        background: linear-gradient(135deg, #c1a067, #a8894f);
        color: white;
    }

    /* Modal */
    .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }

    /* Dark Mode */
    body.dark-mode .ticket-code-box {
        background: #1e1e2a;
        border-color: #c1a067;
    }

    body.dark-mode .info-card {
        background: #1e1e2a !important;
        border-color: #2d2d3a;
    }

    body.dark-mode .info-card:hover {
        border-color: #c1a067;
    }

    body.dark-mode .alert-custom {
        background: #1e1e2a;
    }

    body.dark-mode .bank-detail {
        background: #1e1e2a;
        border-color: #2d2d3a;
    }

    body.dark-mode .btn-outline-custom {
        background: #1e1e2a;
        border-color: #c1a067;
        color: #c1a067;
    }

    body.dark-mode .btn-outline-custom:hover {
        background: #c1a067;
        color: #1c3451;
    }

    body.dark-mode .caldera-input {
        background: #1e1e2a;
        border-color: #2d2d3a;
        color: #dce8f0;
    }

    body.dark-mode .caldera-input[readonly] {
        background: #2d2d3a;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/reservation/ticket/success.blade.php ENDPATH**/ ?>