<?php $__env->startSection('title', 'Pembayaran DP'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent text-center pt-4">
                    <i class="fas fa-credit-card fa-3x mb-3" style="color: #c1a067;"></i>
                    <h4 class="fw-bold" style="color: #1c3451;">Pembayaran DP</h4>
                    <p class="text-muted">Booking Code: <strong><?php echo e($reservation->booking_code); ?></strong></p>
                </div>
                
                <div class="card-body p-4">
                    <!-- Informasi DP -->
                    <div class="alert alert-warning mb-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x me-3" style="color: #c1a067;"></i>
                            <div>
                                <strong class="d-block">DP Rp <?php echo e(number_format($dpAmount, 0, ',', '.')); ?></strong>
                                <small>Silakan transfer sesuai nominal di atas ke salah satu rekening berikut</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informasi Reservasi -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3" style="color: #1c3451;">Detail Reservasi:</h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Tanggal</small>
                                    <p class="mb-0 fw-semibold"><?php echo e(\Carbon\Carbon::parse($reservation->reservation_date)->format('d F Y')); ?></p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Jam</small>
                                    <p class="mb-0 fw-semibold"><?php echo e($reservation->reservation_time); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Jumlah Tamu</small>
                                    <p class="mb-0 fw-semibold"><?php echo e($reservation->number_of_guests); ?> orang</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bank Accounts -->
                    <h6 class="mb-3 fw-bold" style="color: #1c3451;">Pilih Rekening Tujuan:</h6>
                    <div class="row g-3 mb-4">
                        <?php $__currentLoopData = $bankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4">
                            <div class="bank-card p-3 rounded-3 text-center">
                                <i class="fas fa-university fa-2x mb-2" style="color: #c1a067;"></i>
                                <h6 class="fw-bold mb-1"><?php echo e($bank['bank']); ?></h6>
                                <p class="mb-0 small fw-bold"><?php echo e($bank['account_number']); ?></p>
                                <small class="text-muted">a.n. <?php echo e($bank['account_name']); ?></small>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- Upload Form -->
                    <h6 class="mb-3 fw-bold" style="color: #1c3451;">Upload Bukti Transfer:</h6>
                    <form action="<?php echo e(route('reservation.table.upload-payment', $reservation->booking_code)); ?>" 
                          method="POST" 
                          enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Bank Asal Transfer</label>
                                <select name="bank_from" class="form-control" required>
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
                            
                            <div class="col-md-6">
                                <label class="form-label">Nama Pemilik Rekening Pengirim</label>
                                <input type="text" name="account_name" class="form-control" required>
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label">ID Transaksi (Opsional)</label>
                                <input type="text" name="transaction_id" class="form-control" 
                                       placeholder="Masukkan kode unik transfer jika ada">
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label">Upload Bukti Transfer</label>
                                <input type="file" name="payment_proof" class="form-control" 
                                       accept="image/*" required>
                                <small class="text-muted">Format: JPG, PNG (Max 2MB)</small>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-3 mt-4">
                            <a href="<?php echo e(route('reservation.table')); ?>" class="btn btn-outline-secondary flex-grow-1">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-submit flex-grow-1">
                                <i class="fas fa-upload me-2"></i> Upload & Lanjutkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bank-card {
    background: #f8f9fa;
    border: 1.5px solid #e8e0d0;
    border-radius: 12px;
    transition: all 0.2s;
    cursor: pointer;
}
.bank-card:hover {
    border-color: #c1a067;
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(193,160,103,0.1);
}
.btn-submit {
    background: linear-gradient(135deg, #1c3451, #01516e);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 12px;
    font-weight: 600;
    transition: all 0.2s;
}
.btn-submit:hover {
    background: linear-gradient(135deg, #c1a067, #a8894f);
    transform: translateY(-2px);
}
.btn-outline-secondary {
    border: 1.5px solid #c1a067;
    color: #c1a067;
    background: white;
}
.btn-outline-secondary:hover {
    background: #c1a067;
    color: white;
}
.form-control {
    border: 1.5px solid #e8e0d0;
    border-radius: 8px;
    padding: 10px 12px;
}
.form-control:focus {
    border-color: #c1a067;
    box-shadow: 0 0 0 3px rgba(193,160,103,0.1);
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/reservation/table/payment.blade.php ENDPATH**/ ?>