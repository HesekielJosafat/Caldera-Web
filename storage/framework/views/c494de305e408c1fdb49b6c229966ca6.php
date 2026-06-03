<?php $__env->startSection('title', 'Reservasi Meja'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-2" style="font-family: 'Playfair Display', serif; color: #1c3451;">Table Reservation</h1>
        <div class="section-divider"></div>
        <p class="lead text-muted">Book your table for an unforgettable dining experience</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm caldera-card">
                <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                    <div class="text-center">
                        <i class="fab fa-whatsapp fa-2x mb-2" style="color: #25D366;"></i>
                        <h4 class="fw-bold mb-1" style="color: #1c3451; font-family: 'Playfair Display', serif;">Reservation Form</h4>
                        <p class="text-muted small mb-0">Fill out the form below & we'll confirm via WhatsApp</p>
                    </div>
                </div>
                
                <div class="card-body p-4 p-lg-5">
                    <form id="reservationForm" method="POST" action="<?php echo e(route('reservation.table.store')); ?>">
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
                                    <i class="fas fa-user me-1" style="color: #c1a067;"></i> Full Name 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="customer_name" class="form-control caldera-input" 
                                    placeholder="Enter your full name" value="<?php echo e(old('customer_name')); ?>" required>
                            </div>
                            
                            <!-- Nomor Telepon (WA) - WAJIB -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fab fa-whatsapp me-1" style="color: #25D366;"></i> WhatsApp Number 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="tel" name="customer_phone" class="form-control caldera-input" 
                                    placeholder="0812-3456-7890" value="<?php echo e(old('customer_phone')); ?>" required>
                                <small class="text-muted" style="font-size: 11px;">
                                    <i class="fas fa-info-circle me-1"></i>We'll send confirmation to this number
                                </small>
                            </div>
                            
                            <!-- Jumlah Tamu -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-users me-1" style="color: #c1a067;"></i> Number of Guests 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="number_of_guests" class="form-control caldera-input" 
                                    min="1" max="50" placeholder="2" value="<?php echo e(old('number_of_guests')); ?>" required>
                            </div>
                            
                            <!-- Tanggal Reservasi -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-calendar-day me-1" style="color: #c1a067;"></i> Reservation Date 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="reservation_date" id="reservation_date" class="form-control caldera-input" 
                                    min="<?php echo e($minDate ?? date('Y-m-d')); ?>" max="<?php echo e($maxDate ?? date('Y-m-d', strtotime('+30 days'))); ?>" 
                                    value="<?php echo e(old('reservation_date')); ?>" required>
                            </div>
                            
                            <!-- Jam Reservasi - Dynamic -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-clock me-1" style="color: #c1a067;"></i> Reservation Time 
                                    <span class="text-danger">*</span>
                                </label>
                                
                                <div id="timeSlotsContainer">
                                    <div class="text-muted text-center py-3" id="timeSlotsLoading">
                                        <i class="fas fa-calendar-alt me-2"></i> Please select a date first
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Permintaan Khusus -->
                            <div class="col-12">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-comment me-1" style="color: #c1a067;"></i> Special Requests
                                </label>
                                <textarea name="special_requests" class="form-control caldera-input" 
                                          rows="3" placeholder="Example: baby chair, non-smoking area, vegetarian preference, etc."><?php echo e(old('special_requests')); ?></textarea>
                            </div>
                            
                            <!-- Info Alert -->
                            <div class="col-12 mt-3">
                                <div class="alert-custom">
                                    <div class="d-flex align-items-center">
                                        <i class="fab fa-whatsapp fa-lg me-3" style="color: #25D366;"></i>
                                        <div>
                                            <strong class="small" style="color: #1c3451;">Confirmation via WhatsApp:</strong>
                                            <p class="mb-0 small text-muted">Reservation confirmation will be sent to your WhatsApp number within 24 hours.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex gap-3 mt-5">
                            <a href="<?php echo e(route('branding.home')); ?>" class="btn btn-outline-custom flex-grow-1">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-submit flex-grow-1">
                                <i class="fab fa-whatsapp me-2"></i> Reserve Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Operating Hours Card -->
            <div class="card border-0 shadow-sm mt-4 caldera-card">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <i class="fas fa-utensils fa-2x mb-2" style="color: #c1a067;"></i>
                            <h6 class="fw-bold mb-1" style="color: #1c3451;">Restaurant Hours</h6>
                            <p class="small text-muted mb-0">
                                Monday - Friday: 10:00 - 22:00<br>
                                Saturday - Sunday: 09:00 - 23:00
                            </p>
                        </div>
                        <div class="col-md-6">
                            <i class="fab fa-whatsapp fa-2x mb-2" style="color: #25D366;"></i>
                            <h6 class="fw-bold mb-1" style="color: #1c3451;">Contact Us</h6>
                            <p class="small text-muted mb-0">
                                WhatsApp: 0812-3456-7890<br>
                                Call: (022) 1234567
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap');

    .display-4 {
        font-family: 'Playfair Display', serif;
        color: #1c3451;
    }

    .section-divider {
        width: 50px;
        height: 3px;
        background: #c1a067;
        margin: 12px auto 16px;
        border-radius: 2px;
    }

    .caldera-card {
        border-radius: 20px !important;
        overflow: hidden;
        transition: transform 0.25s, box-shadow 0.25s;
    }

    .caldera-card:hover {
        box-shadow: 0 12px 28px rgba(28,52,81,0.12) !important;
    }

    /* Form Input Styling */
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

    .caldera-input:hover:not(:focus) {
        border-color: #c1a067;
    }

    /* Time Slot Radio Styling */
    .time-slot {
        display: block;
        cursor: pointer;
        margin-bottom: 0;
        width: 100%;
    }
    
    .time-slot input {
        display: none;
    }
    
    .time-slot span {
        display: block;
        padding: 8px 12px;
        background: #f8f6f2;
        border: 1.5px solid #e8e0d0;
        border-radius: 10px;
        text-align: center;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .time-slot input:checked + span {
        background: #1c3451;
        border-color: #1c3451;
        color: white;
    }
    
    .time-slot span:hover {
        border-color: #c1a067;
        background: #fff;
        transform: translateY(-2px);
    }

    /* Weekend slot styling */
    .weekend-slot span {
        background: #f0f9f0;
        border-color: #c8e6c8;
    }

    .weekend-slot input:checked + span {
        background: #2e7d32;
        border-color: #2e7d32;
        color: white;
    }

    .time-slot.weekend-slot span:hover {
        border-color: #4caf50;
        background: #e8f5e9;
    }

    /* Label Styling */
    .form-label {
        font-size: 13px;
        margin-bottom: 8px;
        letter-spacing: 0.3px;
    }

    /* Alert Custom */
    .alert-custom {
        background: #fdfcfa;
        border-left: 4px solid #25D366;
        padding: 16px 20px;
        border-radius: 12px;
    }

    /* Buttons */
    .btn-outline-custom {
        background: white;
        color: #1c3451;
        border: 1.5px solid #1c3451;
        border-radius: 12px;
        padding: 12px 20px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn-outline-custom:hover {
        background: #1c3451;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(28,52,81,0.2);
    }

    .btn-submit {
        background: linear-gradient(135deg, #25D366, #128C7E);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 20px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #128C7E, #075E54);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37,211,102,0.3);
    }

    .info-alert {
        background: #e3f2fd;
        border-left: 4px solid #2196f3;
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 12px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 20px !important;
        }
        
        .btn-submit, .btn-outline-custom {
            padding: 10px 16px;
            font-size: 13px;
        }
        
        .time-slot span {
            padding: 6px 8px;
            font-size: 11px;
        }
    }

    /* Dark Mode */
    body.dark-mode .caldera-input {
        background: #1e1e2a;
        border-color: #2d2d3a;
        color: #dce8f0;
    }

    body.dark-mode .caldera-input:focus {
        border-color: #c1a067;
    }

    body.dark-mode .alert-custom {
        background: #1e1e2a;
        border-left-color: #25D366;
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

    body.dark-mode .time-slot span {
        background: #1e1e2a;
        border-color: #2d2d3a;
        color: #dce8f0;
    }
    
    body.dark-mode .time-slot input:checked + span {
        background: #c1a067;
        border-color: #c1a067;
        color: #1c3451;
    }

    body.dark-mode .weekend-slot span {
        background: #1a2a1a;
        border-color: #2e7d32;
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .caldera-card {
        animation: fadeInUp 0.5s ease;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('reservation_date');
    const timeSlotsContainer = document.getElementById('timeSlotsContainer');
    const oldTimeValue = '<?php echo e(old("reservation_time")); ?>';
    
    // Definisi slot waktu
    const weekdaySlots = [
        '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00',
        '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00',
        '20:00:00', '21:00:00'
    ];
    
    const weekendSlots = [
        '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00',
        '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00',
        '19:00:00', '20:00:00', '21:00:00', '22:00:00'
    ];
    
    // Format jam untuk ditampilkan
    function formatTimeDisplay(time) {
        const hour = parseInt(time.split(':')[0]);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const hour12 = hour % 12 || 12;
        return `${hour12}:00 ${ampm}`;
    }
    
    // Generate HTML untuk time slots
    function generateTimeSlots(slots, isWeekend, dayName) {
        let html = `
            <div class="info-alert mb-3">
                <i class="fas fa-clock me-1"></i>
                <strong>Operating Hours for ${dayName}:</strong>
                ${isWeekend ? '09:00 - 23:00' : '10:00 - 22:00'}
            </div>
            <div class="row">
        `;
        
        slots.forEach(time => {
            const isChecked = (oldTimeValue === time) ? 'checked' : '';
            const slotClass = isWeekend ? 'weekend-slot' : '';
            html += `
                <div class="col-md-2 col-4 mb-2">
                    <label class="time-slot ${slotClass}">
                        <input type="radio" name="reservation_time" value="${time}" ${isChecked} required>
                        <span>🕐 ${formatTimeDisplay(time)}</span>
                    </label>
                </div>
            `;
        });
        
        html += `</div>`;
        return html;
    }
    
    // Nama hari dalam bahasa Indonesia
    function getDayName(dayIndex) {
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const daysIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        return {
            en: days[dayIndex],
            id: daysIndo[dayIndex]
        };
    }
    
    // Fungsi utama untuk update time slots berdasarkan tanggal
    function updateTimeSlots() {
        const selectedDate = dateInput.value;
        
        if (!selectedDate) {
            timeSlotsContainer.innerHTML = `
                <div class="text-muted text-center py-4 bg-light rounded">
                    <i class="fas fa-calendar-alt fa-2x mb-2 opacity-50"></i>
                    <p class="mb-0">Please select a reservation date first</p>
                    <small class="text-muted">Time slots will appear based on selected date</small>
                </div>
            `;
            return;
        }
        
        const date = new Date(selectedDate);
        const dayOfWeek = date.getDay(); // 0 = Minggu, 1 = Senin, ..., 6 = Sabtu
        const isWeekend = (dayOfWeek === 0 || dayOfWeek === 6);
        const dayName = getDayName(dayOfWeek);
        
        let html = '';
        
        // IF SEDERHANA untuk menentukan jam berdasarkan hari
        if (isWeekend) {
            // Weekend: Sabtu atau Minggu
            html = generateTimeSlots(weekendSlots, true, `${dayName.id} (Weekend)`);
        } else {
            // Weekday: Senin sampai Jumat
            html = generateTimeSlots(weekdaySlots, false, `${dayName.id} (Weekday)`);
        }
        
        // Tambahkan note penting
        html += `
            <div class="alert alert-warning mt-3 py-2 small" style="background: #fff3e0; border: none; font-size: 11px;">
                <i class="fas fa-info-circle me-1"></i>
                <strong>Note:</strong> Your table will be held for 30 minutes after the reservation time.
            </div>
        `;
        
        timeSlotsContainer.innerHTML = html;
    }
    
    // Event listener ketika tanggal berubah
    dateInput.addEventListener('change', updateTimeSlots);
    dateInput.addEventListener('input', updateTimeSlots);
    
    // Jika tanggal sudah terisi saat load (misal dari old value)
    if (dateInput.value) {
        updateTimeSlots();
    }
});
</script>
<?php $__env->stopPush(); ?>    
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/reservation/table/create.blade.php ENDPATH**/ ?>