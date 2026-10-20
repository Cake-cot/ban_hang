<!DOCTYPE HTML>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= isset($data['title']) ? htmlspecialchars($data['title']) . ' - ' : '' ?><?= SITENAME; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Template & Custom CSS -->
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/tasty/css/bootstrap.css">
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/tasty/css/custom-shop.css?v=<?= time(); ?>">
</head>
<body>
    <div id="page">
    
    <!-- MODERN STICKY NAVBAR -->
    <header class="site-navbar">
        <div class="container">
            <div class="nav-wrapper">
                <!-- Brand Logo -->
                <a href="<?= URLROOT; ?>" class="brand-logo">
                    <i class="fa-solid fa-fire-flame-curved" style="color: #dc2626;"></i>
                    <span>2Hand Kicks<span class="logo-dot">.</span></span>
                    <span class="logo-tag">Auth</span>
                </a>

                <!-- Navigation Links -->
                <ul class="nav-links hidden-xs hidden-sm">
                    <li class="<?= empty($data['current_category']) && !isset($data['keyword']) && (isset($data['title']) && $data['title'] == 'Trang Chủ') ? 'active' : ''; ?>">
                        <a href="<?= URLROOT; ?>"><i class="fa-solid fa-house me-1"></i> Trang chủ</a>
                    </li>
                    <li class="<?= (isset($data['current_category']) && $data['current_category'] == 'nam') ? 'active' : ''; ?>">
                        <a href="<?= URLROOT; ?>/product/category/nam">Giày Nam</a>
                    </li>
                    <li class="<?= (isset($data['current_category']) && $data['current_category'] == 'nu') ? 'active' : ''; ?>">
                        <a href="<?= URLROOT; ?>/product/category/nu">Giày Nữ</a>
                    </li>
                    <li class="<?= (isset($data['current_category']) && $data['current_category'] == 'sneaker') ? 'active' : ''; ?>">
                        <a href="<?= URLROOT; ?>/product/category/sneaker">Sneaker</a>
                    </li>
                    <li class="<?= (isset($data['current_category']) && $data['current_category'] == 'boot') ? 'active' : ''; ?>">
                        <a href="<?= URLROOT; ?>/product/category/boot">Boot</a>
                    </li>
                    <li class="<?= (isset($data['current_category']) && $data['current_category'] == 'slip-on') ? 'active' : ''; ?>">
                        <a href="<?= URLROOT; ?>/product/category/slip-on">Slip-on</a>
                    </li>
                </ul>

                <!-- Action Items: Search, User, Cart -->
                <div class="nav-actions">
                    <!-- Search input -->
                    <form action="<?= URLROOT; ?>/product/search" method="GET" class="nav-search-form hidden-xs">
                        <input type="text" name="q" class="nav-search-input" placeholder="Tìm giày, hãng..." value="<?= htmlspecialchars($data['keyword'] ?? ''); ?>">
                        <button type="submit" class="nav-search-btn" title="Tìm kiếm"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>

                    <!-- User Account -->
                    <?php if(isset($_SESSION['user_id'])) : ?>
                        <div class="dropdown" style="display:inline-block;">
                            <button class="user-dropdown-btn dropdown-toggle" type="button" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="fa-regular fa-circle-user text-danger"></i>
                                <span><?= htmlspecialchars($_SESSION['user_name']); ?></span>
                                <i class="fa-solid fa-angle-down" style="font-size: 11px;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu" style="border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-top: 8px; padding: 6px 0;">
                                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                    <li><a href="<?= URLROOT; ?>/admin" style="color: #dc2626; font-weight: bold; padding: 8px 16px;"><i class="fa-solid fa-gauge me-2"></i> Trang Quản trị (Admin)</a></li>
                                    <li role="separator" class="divider"></li>
                                <?php endif; ?>
                                <li><a href="<?= URLROOT; ?>/user/orders" style="padding: 8px 16px;"><i class="fa-solid fa-box-open me-2"></i> Đơn hàng của tôi</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="<?= URLROOT; ?>/user/logout" style="color: #64748b; padding: 8px 16px;"><i class="fa-solid fa-right-from-bracket me-2"></i> Đăng xuất</a></li>
                            </ul>
                        </div>
                    <?php else : ?>
                        <a href="<?= URLROOT; ?>/user/login" class="nav-cart-btn" style="border: none; background: transparent; padding: 6px 8px;">
                            <i class="fa-regular fa-user"></i>
                            <span class="hidden-xs">Đăng nhập</span>
                        </a>
                        <a href="<?= URLROOT; ?>/user/register" class="btn-add-cart-fast hidden-xs" style="padding: 6px 12px;">Đăng ký</a>
                    <?php endif; ?>

                    <!-- Shopping Cart -->
                    <a href="<?= URLROOT; ?>/cart" class="nav-cart-btn" title="Xem giỏ hàng">
                        <i class="fa-solid fa-bag-shopping" style="color: #dc2626;"></i>
                        <span class="hidden-xs">Giỏ hàng</span>
                        <span class="cart-badge"><?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
                    </a>
                </div>
            </div>

            <!-- Mobile Category Bar (visible only on small screens) -->
            <div class="visible-xs visible-sm" style="margin-top: 10px; padding-top: 8px; border-top: 1px solid #f1f5f9; overflow-x: auto; white-space: nowrap;">
                <a href="<?= URLROOT; ?>" style="display:inline-block; padding: 4px 10px; font-size: 13px; font-weight: 600;">Trang chủ</a>
                <a href="<?= URLROOT; ?>/product/category/nam" style="display:inline-block; padding: 4px 10px; font-size: 13px; font-weight: 600;">Giày Nam</a>
                <a href="<?= URLROOT; ?>/product/category/nu" style="display:inline-block; padding: 4px 10px; font-size: 13px; font-weight: 600;">Giày Nữ</a>
                <a href="<?= URLROOT; ?>/product/category/sneaker" style="display:inline-block; padding: 4px 10px; font-size: 13px; font-weight: 600;">Sneaker</a>
                <a href="<?= URLROOT; ?>/product/category/boot" style="display:inline-block; padding: 4px 10px; font-size: 13px; font-weight: 600;">Boot</a>
                <a href="<?= URLROOT; ?>/product/category/slip-on" style="display:inline-block; padding: 4px 10px; font-size: 13px; font-weight: 600;">Slip-on</a>
            </div>
        </div>
    </header>

    <!-- FLASH MESSAGES ALERT CONTAINER -->
    <div class="flash-alert-container">
        <?php if(!empty($_SESSION['flash_success'])) : ?>
            <div class="flash-alert flash-alert-success">
                <div><i class="fa-solid fa-circle-check me-2"></i> <?= $_SESSION['flash_success']; ?></div>
                <button type="button" style="background:none;border:none;cursor:pointer;color:inherit;font-weight:bold;" onclick="this.parentElement.remove();">&times;</button>
            </div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>

        <?php if(!empty($_SESSION['flash_error'])) : ?>
            <div class="flash-alert flash-alert-error">
                <div><i class="fa-solid fa-circle-exclamation me-2"></i> <?= $_SESSION['flash_error']; ?></div>
                <button type="button" style="background:none;border:none;cursor:pointer;color:inherit;font-weight:bold;" onclick="this.parentElement.remove();">&times;</button>
            </div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <?php if(!empty($_SESSION['flash_info'])) : ?>
            <div class="flash-alert flash-alert-info">
                <div><i class="fa-solid fa-circle-info me-2"></i> <?= $_SESSION['flash_info']; ?></div>
                <button type="button" style="background:none;border:none;cursor:pointer;color:inherit;font-weight:bold;" onclick="this.parentElement.remove();">&times;</button>
            </div>
            <?php unset($_SESSION['flash_info']); ?>
        <?php endif; ?>
    </div>
