    <!-- SUBPAGE HEADER -->
    <div class="subpage-header">
        <div class="container">
            <h1 class="subpage-title">Giỏ hàng của bạn</h1>
            <ul class="breadcrumb-custom">
                <li><a href="<?= URLROOT; ?>">Trang chủ</a></li>
                <li style="color: #dc2626;">Giỏ hàng</li>
            </ul>
        </div>
    </div>

    <!-- MAIN CART CONTENT -->
    <div class="container" style="padding-bottom: 60px;">
        <?php if(empty($data['items'])) : ?>
            <div class="cart-card" style="text-align: center; padding: 70px 20px;">
                <i class="fa-solid fa-cart-shopping" style="font-size: 50px; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h3 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Giỏ hàng của bạn đang trống</h3>
                <p style="color: #64748b; font-size: 14px; margin-bottom: 25px;">Hãy khám phá các mẫu giày độc bản vừa mới lên kệ để chọn cho mình đôi ưng ý nhất nhé!</p>
                <a href="<?= URLROOT; ?>" class="btn-add-cart-large">
                    <i class="fa-solid fa-shoe-prints me-2"></i> Khám phá sản phẩm ngay
                </a>
            </div>
        <?php else : ?>
            <div class="row">
                <!-- Left: Cart Items List -->
                <div class="col-md-8 col-sm-12">
                    <div class="cart-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 15px; border-bottom: 1px solid #e2e8f0; margin-bottom: 10px;">
                            <h3 style="font-size: 18px; font-weight: 800; margin: 0; color: #0f172a;">
                                Danh sách giày đã chọn (<?= count($data['items']); ?>)
                            </h3>
                            <span style="font-size: 13px; color: #64748b;">Mỗi mẫu chỉ có 1 đôi duy nhất</span>
                        </div>

                        <?php foreach($data['items'] as $item) : ?>
                            <div class="cart-item-row">
                                <img src="<?= htmlspecialchars($item->image_url); ?>" class="cart-item-thumb" alt="<?= htmlspecialchars($item->name); ?>">
                                
                                <div class="cart-item-info">
                                    <div class="cart-item-name">
                                        <a href="<?= URLROOT; ?>/product/detail/<?= $item->slug; ?>">
                                            <?= htmlspecialchars($item->name); ?>
                                        </a>
                                    </div>
                                    <div class="cart-item-meta">
                                        <span class="spec-badge">Size <?= htmlspecialchars($item->size); ?></span>
                                        <span class="spec-badge">Cond: <?= htmlspecialchars($item->condition_status); ?></span>
                                    </div>
                                </div>

                                <div class="cart-item-price">
                                    <?= number_format($item->price, 0, ',', '.'); ?> đ
                                </div>

                                <div>
                                    <a href="<?= URLROOT; ?>/cart/remove/<?= $item->id; ?>" class="cart-item-remove" title="Xóa khỏi giỏ" onclick="return confirm('Bạn có chắc muốn xóa đôi giày này khỏi giỏ hàng?');">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
                            <a href="<?= URLROOT; ?>" style="font-size: 14px; font-weight: 600; color: #64748b;">
                                <i class="fa-solid fa-arrow-left me-1"></i> Tiếp tục chọn thêm giày khác
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right: Checkout Box -->
                <div class="col-md-4 col-sm-12">
                    <div class="checkout-box">
                        <div class="checkout-title">
                            <i class="fa-solid fa-receipt text-danger me-2"></i> Tóm tắt đơn hàng
                        </div>

                        <div class="checkout-row">
                            <span>Tạm tính (<?= count($data['items']); ?> sản phẩm):</span>
                            <strong><?= number_format($data['total'], 0, ',', '.'); ?> đ</strong>
                        </div>

                        <div class="checkout-row">
                            <span>Phí vận chuyển:</span>
                            <span style="color: #16a34a; font-weight: 700;"><i class="fa-solid fa-truck-fast me-1"></i> Miễn phí</span>
                        </div>

                        <div class="checkout-row">
                            <span>Bảo hiểm hàng hóa:</span>
                            <span style="color: #16a34a; font-weight: 700;">Miễn phí</span>
                        </div>

                        <div class="checkout-total-row">
                            <span>Tổng thanh toán:</span>
                            <span><?= number_format($data['total'], 0, ',', '.'); ?> đ</span>
                        </div>

                        <div style="margin-top: 20px;">
                            <?php if(!isset($_SESSION['user_id'])) : ?>
                                <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 14px; margin-bottom: 15px; font-size: 13px; color: #991b1b;">
                                    <i class="fa-solid fa-circle-exclamation me-1"></i> Vui lòng <strong>đăng nhập</strong> tài khoản để lưu thông tin đơn hàng và theo dõi hành trình giao nhận.
                                </div>
                                <a href="<?= URLROOT; ?>/user/login" class="btn-primary-block" style="text-align: center; display: block; text-decoration: none;">
                                    <i class="fa-solid fa-arrow-right-to-bracket me-2"></i> Đăng nhập để thanh toán
                                </a>
                                <div style="text-align: center; margin-top: 10px; font-size: 13px;">
                                    Chưa có tài khoản? <a href="<?= URLROOT; ?>/user/register" style="font-weight: 700; color: #dc2626;">Đăng ký ngay</a>
                                </div>
                            <?php else: ?>
                                <form action="<?= URLROOT; ?>/cart/checkout" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">
                                    
                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <label for="shipping_address"><i class="fa-solid fa-map-location-dot me-1 text-danger"></i> Địa chỉ nhận hàng *</label>
                                        <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3" required placeholder="Số nhà, tên đường, Phường/Xã, Quận/Huyện, Tỉnh/TP"></textarea>
                                    </div>

                                    <div style="font-size: 12px; color: #64748b; margin-bottom: 15px;">
                                        <i class="fa-solid fa-shield-halved text-success me-1"></i> Phương thức: Thanh toán khi nhận hàng (COD). Được kiểm tra và thử giày trước khi thanh toán.
                                    </div>

                                    <button type="submit" class="btn-primary-block">
                                        <i class="fa-solid fa-lock me-1"></i> Xác Nhận Đặt Hàng Ngay
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
