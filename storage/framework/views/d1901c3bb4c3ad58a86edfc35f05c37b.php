<footer class="footer pt-5 mt-5">
    <div class="container">
        <div class="row">
            <!-- Brand Section -->
            <div class="col-md-4 mb-4">
                <div class="mb-3">
                    <div style="font-family: 'Playfair Display', serif; color: #c1a067; font-size: 1.4rem; font-weight: 700; line-height: 1.2; margin-bottom: 10px;">
                        Caldera Resto<br>& Pool
                    </div>
                    <p class="footer-text small">Experience the perfect blend of culinary delight and refreshing pool experience.</p>
                </div>
                <ul class="d-flex list-unstyled gap-3">
                    <li><a href="https://www.instagram.com/calderarestoandpool/" class="footer-social"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="https://www.tiktok.com/@caldera.resto.cof7" class="footer-social"><i class="fab fa-tiktok"></i></a></li>
                </ul>
            </div>

            <!-- Quick Links -->
            <div class="col-md-2 col-sm-6 mb-4">
                <h6 class="footer-heading mb-3" style="color: #c1a067 !important;">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="<?php echo e(route('branding.home')); ?>" class="footer-link">Home</a></li>
                    <li class="mb-2"><a href="<?php echo e(route('branding.about')); ?>" class="footer-link">About Us</a></li>
                    <li class="mb-2"><a href="<?php echo e(route('branding.menu')); ?>" class="footer-link">Menu</a></li>
                    <li class="mb-2"><a href="<?php echo e(route('branding.pool')); ?>" class="footer-link">Pool</a></li>
                    <li class="mb-2"><a href="<?php echo e(route('branding.gallery')); ?>" class="footer-link">Gallery</a></li>
                </ul>
            </div>

            <!-- Information -->
            <div class="col-md-3 col-sm-6 mb-4">
                <h6 class="footer-heading mb-3" style="color: #c1a067 !important;">Information</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="<?php echo e(route('branding.promos')); ?>" class="footer-link">Promos & Events</a></li>
                    <li class="mb-2"><a href="<?php echo e(route('branding.testimonials')); ?>" class="footer-link">Testimonials</a></li>
                    <li class="mb-2"><a href="<?php echo e(route('branding.contact')); ?>" class="footer-link">Contact Us</a></li>
                    <li class="mb-2"><a href="<?php echo e(route('reservation.table')); ?>" class="footer-link">Book a Table</a></li>
                    <li class="mb-2"><a href="<?php echo e(route('reservation.ticket')); ?>" class="footer-link">Buy Pool Ticket</a></li>
                </ul>
            </div>

            <!-- Contact Info + Mini Map (ALAMAT ASLI) -->
            <div class="col-md-3 mb-4">
                <h6 class="footer-heading mb-3" style="color: #c1a067 !important;">Find Us</h6>
                
                <!-- Contact details sesuai Google Maps -->
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex">
                        <i class="fas fa-map-marker-alt footer-icon mt-1 me-3"></i>
                        <span class="footer-text small">Jl. Patuan Nagari, Sangkar Nihuta, Kec. Balige, Toba, Sumatera Utara 22312</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <i class="fas fa-phone footer-icon mt-1 me-3"></i>
                        <span class="footer-text small">(022) 1234567 / 0812-3456-7890</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <i class="fas fa-envelope footer-icon mt-1 me-3"></i>
                        <span class="footer-text small">info@caldera.com</span>
                    </li>
                </ul>

                <!-- MINI MAPS (embed dari lokasi asli Caldera Resto and Coffee) -->
                <div class="mini-map mt-2" style="border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.2);">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15933.37470040786!2d99.131767!3d2.367627!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302d1f97ddace8ed%3A0xbdf47207860cc8f5!2sCaldera%20Resto%20and%20Coffee!5e0!3m2!1sen!2sid!4v1744100000000!5m2!1sen!2sid" 
                        width="100%" 
                        height="130" 
                        style="border:0; pointer-events: none;" 
                        allowfullscreen="" 
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Caldera Resto and Coffee - Balige, Toba">
                    </iframe>
                </div>
                <p class="footer-text small mt-2 mb-0 text-center">
                    <a href="https://maps.app.goo.gl/dahhwPLVRKnpftdB8" target="_blank" class="footer-link" style="font-size: 11px;">
                        <i class="fas fa-external-link-alt me-1"></i>Open in Google Maps &rarr;
                    </a>
                </p>
            </div>

            <!-- Opening Hours -->
            <div class="col-12">
                <hr class="footer-divider">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="footer-text small mb-2">
                            <i class="fas fa-clock footer-icon me-2"></i>
                            <strong class="footer-strong">Resto Hours:</strong> Monday - Friday: 10:00 - 22:00 | Saturday - Sunday: 09:00 - 23:00
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <p class="footer-text small mb-2">
                            <i class="fas fa-swimmer footer-icon me-2"></i>
                            <strong class="footer-strong">Pool Hours:</strong> Daily: 08:00 - 18:00
                        </p>
                    </div>
                </div>
                <hr class="footer-divider">
            </div>

            <!-- Copyright -->
            <div class="col-12 text-center mt-3 pb-4">
                <p class="footer-text small mb-0">
                    &copy; <?php echo e(date('Y')); ?> Caldera Resto & Pool. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');

.footer {
    background: #1c3451;
    color: #fff;
}

.footer-heading {
    color: #ffffff;
    font-weight: 700;
    letter-spacing: 0.5px;
    font-size: 14px;
    text-transform: uppercase;
    padding-bottom: 8px;
    border-bottom: 2px solid #c1a067;
    display: inline-block;
    margin-bottom: 16px !important;
}

.footer-text {
    color: #dce8f0;
}

.footer-strong {
    color: #ffffff;
}

.footer-link {
    color: #dce8f0;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.2s;
    display: inline-block;
}

.footer-link:hover {
    color: #c1a067;
    transform: translateX(4px);
}

.footer-icon {
    color: #c1a067;
}

.footer-social {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(193,160,103,0.15);
    color: #c1a067;
    text-decoration: none;
    transition: all 0.2s;
    font-size: 14px;
}

.footer-social:hover {
    background: #c1a067;
    color: #1c3451;
    transform: translateY(-3px);
}

.footer-divider {
    border-color: rgba(255,255,255,0.15);
    opacity: 1;
}

.mini-map iframe {
    transition: opacity 0.2s;
}

.mini-map:hover iframe {
    opacity: 0.95;
}

body.dark-mode .footer {
    background: #0d1e30 !important;
}

@media (max-width: 768px) {
    .footer {
        text-align: center;
    }
    .footer .d-flex {
        justify-content: center;
    }
    .footer .text-md-start,
    .footer .text-md-end {
        text-align: center !important;
    }
    .mini-map {
        max-width: 280px;
        margin-left: auto;
        margin-right: auto;
    }
}
</style><?php /**PATH D:\PA_03\PA2\resources\views/components/footer.blade.php ENDPATH**/ ?>