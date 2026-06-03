

<?php $__env->startSection('title', 'Menu Caldera'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-2">Our Menu</h1>
        <div class="section-divider"></div>
        <p class="lead text-secondary">Discover our delicious selection of food and beverages</p>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="search-wrapper mx-auto" style="max-width: 400px;">
                <div class="input-group" style="background: #fff; border-radius: 50px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <span class="input-group-text border-0 bg-white text-muted ps-4">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control border-0 py-2" placeholder="Search menu..." style="font-size: 14px; box-shadow: none;" id="searchInput">
                    <button class="btn border-0 bg-white text-muted pe-4" type="button" id="searchClearBtn" style="display: none;">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Filter -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="<?php echo e(route('branding.menu')); ?>" class="btn btn-filter <?php echo e(!request('category') ? 'active' : ''); ?>">All</a>
                <a href="<?php echo e(route('branding.menu.category', 'makanan')); ?>" class="btn btn-filter <?php echo e(request('category') == 'makanan' ? 'active' : ''); ?>">Makanan</a>
                <a href="<?php echo e(route('branding.menu.category', 'minuman')); ?>" class="btn btn-filter <?php echo e(request('category') == 'minuman' ? 'active' : ''); ?>">Minuman</a>
                <a href="<?php echo e(route('branding.menu.category', 'dessert')); ?>" class="btn btn-filter <?php echo e(request('category') == 'dessert' ? 'active' : ''); ?>">Dessert</a>
            </div>
        </div>
    </div>

    <!-- Menu Grid -->
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 menu-card">
                <?php if($menu->image): ?>
                    <div class="menu-img-wrap">
                        <img src="<?php echo e(asset('storage/' . $menu->image)); ?>" class="card-img-top menu-img" alt="<?php echo e($menu->name); ?>" style="height: 200px; object-fit: cover;">
                    </div>
                <?php else: ?>
                    <div class="menu-img-wrap d-flex align-items-center justify-content-center" style="height: 200px; background: #f0ebe0;">
                        <i class="fas fa-utensils fa-4x" style="color: #c1a067; opacity: 0.5;"></i>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0" style="color: #1c3451;"><?php echo e($menu->name); ?></h5>
                        <span class="menu-price">Rp <?php echo e(number_format($menu->price, 0, ',', '.')); ?></span>
                    </div>
                    <p class="text-muted small"><?php echo e(Str::limit($menu->description, 100)); ?></p>
                    <?php if($menu->is_recommended): ?>
                        <span class="badge recommended-badge">⭐ Recommended</span>
                    <?php endif; ?>
                </div>
                
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center py-5">
            <i class="fas fa-utensils fa-4x mb-3" style="color: #c1a067; opacity: 0.5;"></i>
            <p class="text-muted">Menu sedang kosong</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="mt-5">
        <?php echo e($menus->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');

    h1.display-4 {
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

    .btn-filter {
        background: white;
        color: #4a5568;
        border: 1.5px solid #d1d5db;
        border-radius: 20px;
        padding: 6px 20px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-filter:hover {
        border-color: #1c3451;
        color: #1c3451;
    }

    .btn-filter.active {
        background: #1c3451;
        color: white;
        border-color: #1c3451;
    }

    .menu-card {
        border-radius: 16px !important;
        overflow: hidden;
        transition: transform 0.25s, box-shadow 0.25s;
        border-top: 3px solid transparent !important;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(28,52,81,0.12) !important;
        border-top: 3px solid #c1a067 !important;
    }

    .menu-img-wrap {
        overflow: hidden;
    }

    .menu-img {
        transition: transform 0.3s ease;
        width: 100%;
    }

    .menu-card:hover .menu-img {
        transform: scale(1.05);
    }

    .menu-price {
        color: #c1a067;
        font-weight: 700;
        font-size: 15px;
        white-space: nowrap;
    }

    .recommended-badge {
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
        font-weight: 600;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
    }

    

    .search-wrapper {
    position: relative;
    }

    .search-wrapper .input-group {
        transition: all 0.3s ease;
    }

    .search-wrapper .input-group:focus-within {
        box-shadow: 0 4px 12px rgba(28,52,81,0.15) !important;
        transform: translateY(-1px);
    }

    #searchInput:focus {
        outline: none;
    }

    #searchClearBtn {
        transition: all 0.2s;
    }

    #searchClearBtn:hover {
        color: #c1a067 !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('searchClearBtn');
    const menuCards = document.querySelectorAll('.menu-card');
    const noResultMsg = document.createElement('div');
    noResultMsg.className = 'col-12 text-center py-5';
    noResultMsg.innerHTML = `
        <i class="fas fa-search fa-4x mb-3" style="color: #c1a067; opacity: 0.5;"></i>
        <p class="text-muted">No menu found matching your search</p>
    `;
    noResultMsg.style.display = 'none';
    
    const menuGrid = document.querySelector('.row.g-4');
    menuGrid.parentNode.appendChild(noResultMsg);
    
    function filterMenu() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;
        
        if (searchTerm === '') {
            clearBtn.style.display = 'none';
        } else {
            clearBtn.style.display = 'block';
        }
        
        menuCards.forEach(card => {
            const title = card.querySelector('.fw-bold')?.textContent.toLowerCase() || '';
            const description = card.querySelector('.text-muted')?.textContent.toLowerCase() || '';
            const price = card.querySelector('.menu-price')?.textContent.toLowerCase() || '';
            
            if (title.includes(searchTerm) || description.includes(searchTerm) || price.includes(searchTerm)) {
                card.closest('.col-md-6')?.classList.remove('d-none');
                visibleCount++;
            } else {
                card.closest('.col-md-6')?.classList.add('d-none');
            }
        });
        
        // Show/hide no result message
        if (visibleCount === 0 && searchTerm !== '') {
            noResultMsg.style.display = 'block';
            menuGrid.style.display = 'none';
        } else {
            noResultMsg.style.display = 'none';
            menuGrid.style.display = 'flex';
        }
    }
    
    searchInput.addEventListener('input', filterMenu);
    
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        filterMenu();
        searchInput.focus();
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\PA2_Kel6\resources\views/pages/menu.blade.php ENDPATH**/ ?>