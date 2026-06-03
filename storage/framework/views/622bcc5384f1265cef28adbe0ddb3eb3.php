<?php $__env->startSection('title', 'Beli Tiket Kolam'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent text-center pt-4">
                    <i class="fas fa-ticket-alt fa-3x mb-3" style="color: #c1a067;"></i>
                    <h4 class="fw-bold" style="color: #1c3451;">Beli Tiket Kolam Renang</h4>
                    <p class="text-muted">Isi form berikut untuk membeli tiket</p>
                </div>
                
                <div class="card-body p-4">
                    <form id="ticketForm" method="POST" action="<?php echo e(route('reservation.ticket.store')); ?>">
                        <?php echo csrf_field(); ?>
                        
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="row g-3">
                            <!-- Nama Lengkap -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-user me-1" style="color: #c1a067;"></i> Nama Lengkap 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="customer_name" class="form-control caldera-input" 
                                       value="<?php echo e(old('customer_name', Auth::user()->name ?? '')); ?>" required>
                            </div>
                            
                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-envelope me-1" style="color: #c1a067;"></i> Email 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="customer_email" class="form-control caldera-input" 
                                       value="<?php echo e(old('customer_email', Auth::user()->email ?? '')); ?>" required>
                            </div>
                            
                            <!-- Nomor Telepon -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-phone me-1" style="color: #c1a067;"></i> Nomor Telepon 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="customer_phone" class="form-control caldera-input" 
                                       value="<?php echo e(old('customer_phone')); ?>" placeholder="0812-3456-7890" required>
                            </div>
                            
                            <!-- Tanggal Kunjungan -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-calendar-day me-1" style="color: #c1a067;"></i> Tanggal Kunjungan 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="visit_date" id="visit_date" class="form-control caldera-input" 
                                       min="<?php echo e(date('Y-m-d')); ?>" value="<?php echo e(old('visit_date')); ?>" required>
                                <small class="text-muted" id="capacityInfo"></small>
                            </div>
                            
                            <!-- Tipe Tiket -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-ticket-alt me-1" style="color: #c1a067;"></i> Tipe Tiket 
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="ticket_type" id="ticket_type" class="form-control caldera-input" required>
                                    <option value="">Pilih Tipe Tiket</option>
                                    <option value="adult" <?php echo e(old('ticket_type') == 'adult' ? 'selected' : ''); ?>>Dewasa - Rp 35.000</option>
                                    <option value="child" <?php echo e(old('ticket_type') == 'child' ? 'selected' : ''); ?>>Anak-anak - Rp 25.000</option>
                                    <option value="family" <?php echo e(old('ticket_type') == 'family' ? 'selected' : ''); ?>>Keluarga (2 Dewasa + 2 Anak) - Rp 100.000</option>
                                </select>
                            </div>
                            
                            <!-- Jumlah Tiket -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-shopping-cart me-1" style="color: #c1a067;"></i> Jumlah Tiket 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="number_of_tickets" id="number_of_tickets" 
                                       class="form-control caldera-input" 
                                       min="1" max="10" value="<?php echo e(old('number_of_tickets', 1)); ?>" required>
                                <small class="text-muted" id="ticketInfo"></small>
                            </div>
                            
                            <!-- Total Harga -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-money-bill me-1" style="color: #c1a067;"></i> Total Harga
                                </label>
                                <div class="form-control-plaintext fw-bold" id="totalPrice" style="color: #c1a067; font-size: 1.2rem;">
                                    Rp 0
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-3 mt-4">
                            <a href="<?php echo e(route('branding.home')); ?>" class="btn btn-outline-custom flex-grow-1">
                                <i class="fas fa-arrow-left me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-submit flex-grow-1">
                                <i class="fas fa-shopping-cart me-2"></i> Beli Tiket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
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
    .btn-outline-custom {
        background: white;
        color: #1c3451;
        border: 1.5px solid #1c3451;
        border-radius: 12px;
        padding: 12px 20px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-outline-custom:hover {
        background: #1c3451;
        color: white;
    }
    .btn-submit {
        background: linear-gradient(135deg, #1c3451, #01516e);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 20px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-submit:hover {
        background: linear-gradient(135deg, #c1a067, #a8894f);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const visitDateInput = document.getElementById('visit_date');
        const ticketTypeSelect = document.getElementById('ticket_type');
        const quantityInput = document.getElementById('number_of_tickets');
        const totalPriceSpan = document.getElementById('totalPrice');
        const capacityInfoSpan = document.getElementById('capacityInfo');
        const ticketInfoSpan = document.getElementById('ticketInfo');
        
        // Harga per tiket
        const prices = {
            'adult': 35000,
            'child': 25000,
            'family': 100000
        };
        
        // Update total harga
        function updateTotalPrice() {
            const ticketType = ticketTypeSelect.value;
            const quantity = parseInt(quantityInput.value) || 0;
            
            if (ticketType && quantity > 0) {
                let pricePerTicket = prices[ticketType];
                let total = pricePerTicket * quantity;
                
                totalPriceSpan.innerHTML = `Rp ${total.toLocaleString('id-ID')}`;
                
                // Informasi tambahan untuk tiket keluarga
                if (ticketType === 'family') {
                    ticketInfoSpan.innerHTML = '💡 Paket keluarga sudah termasuk 2 dewasa + 2 anak';
                    ticketInfoSpan.style.color = '#c1a067';
                } else {
                    ticketInfoSpan.innerHTML = '';
                }
            } else {
                totalPriceSpan.innerHTML = 'Rp 0';
            }
        }
        
        // Cek kapasitas
        function checkCapacity() {
            const visitDate = visitDateInput.value;
            
            if (visitDate) {
                fetch('<?php echo e(route("reservation.ticket.calculate")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        ticket_type: ticketTypeSelect.value || 'adult',
                        number_of_tickets: quantityInput.value || 1,
                        visit_date: visitDate
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.capacity) {
                        if (data.capacity.available <= 0) {
                            capacityInfoSpan.innerHTML = '⚠️ Kuota penuh untuk tanggal ini!';
                            capacityInfoSpan.style.color = 'red';
                        } else if (data.capacity.available < 10) {
                            capacityInfoSpan.innerHTML = `🎟️ Sisa ${data.capacity.available} tiket`;
                            capacityInfoSpan.style.color = 'orange';
                        } else {
                            capacityInfoSpan.innerHTML = `✅ Tersedia ${data.capacity.available} tiket`;
                            capacityInfoSpan.style.color = 'green';
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
        
        // Event listeners
        ticketTypeSelect.addEventListener('change', updateTotalPrice);
        quantityInput.addEventListener('input', updateTotalPrice);
        visitDateInput.addEventListener('change', checkCapacity);
        
        // Panggil saat halaman load (untuk old value)
        if (ticketTypeSelect.value && quantityInput.value) {
            updateTotalPrice();
        }
        if (visitDateInput.value) {
            checkCapacity();
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/reservation/ticket/create.blade.php ENDPATH**/ ?>