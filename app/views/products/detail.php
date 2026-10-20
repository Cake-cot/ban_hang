    <!-- SUBPAGE BREADCRUMB -->
    <div class="subpage-header">
        <div class="container">
            <h1 class="subpage-title"><?= htmlspecialchars($data['product']->name); ?></h1>
            <ul class="breadcrumb-custom">
                <li><a href="<?= URLROOT; ?>">Trang chủ</a></li>
                <li><a href="<?= URLROOT; ?>/product/category/<?= $data['product']->category_name ? strtolower($data['product']->category_name) : 'sneaker'; ?>"><?= htmlspecialchars($data['product']->category_name ?? 'Giày'); ?></a></li>
                <li style="color: #dc2626;"><?= htmlspecialchars($data['product']->name); ?></li>
            </ul>
        </div>
    </div>

    <!-- MAIN PRODUCT DETAIL -->
    <div class="container" style="padding-bottom: 60px;">
        <div class="detail-card">
            <div class="row">
                <!-- Left: Product Image -->
                <div class="col-md-6 col-sm-12 mb-4">
                    <div class="detail-img-box">
                        <img src="<?= htmlspecialchars($data['product']->image_url); ?>" alt="<?= htmlspecialchars($data['product']->name); ?>">
                    </div>
                    <div style="margin-top: 15px; display: flex; justify-content: center; gap: 15px;">
                        <span style="font-size: 13px; color: #64748b;"><i class="fa-solid fa-camera text-danger me-1"></i> Ảnh thực tế 100%</span>
                        <span style="font-size: 13px; color: #64748b;"><i class="fa-solid fa-certificate text-success me-1"></i> Đã kiểm định Auth</span>
                        <span style="font-size: 13px; color: #64748b;"><i class="fa-solid fa-sparkles text-warning me-1"></i> Đã giặt hấp ozone</span>
                    </div>
                </div>

                <!-- Right: Product Information & Action -->
                <div class="col-md-6 col-sm-12">
                    <div style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; margin-bottom: 6px;">
                        <?= htmlspecialchars($data['product']->brand_name ?? 'Sneaker'); ?>
                    </div>
                    <h2 class="detail-title"><?= htmlspecialchars($data['product']->name); ?></h2>

                    <div class="detail-price-box">
                        <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Giá Secondhand Tiết Kiệm:</div>
                        <div class="detail-price"><?= number_format($data['product']->price, 0, ',', '.'); ?> đ</div>
                    </div>

                    <!-- Specs Table -->
                    <table class="detail-specs-table">
                        <tr>
                            <td>Thương hiệu:</td>
                            <td><?= htmlspecialchars($data['product']->brand_name ?? 'Đang cập nhật'); ?></td>
                        </tr>
                        <tr>
                            <td>Danh mục:</td>
                            <td><?= htmlspecialchars($data['product']->category_name ?? 'Giày'); ?></td>
                        </tr>
                        <tr>
                            <td>Size giày:</td>
                            <td><span class="spec-badge" style="font-size: 14px; padding: 4px 10px;">Size <?= htmlspecialchars($data['product']->size); ?></span></td>
                        </tr>
                        <tr>
                            <td>Độ mới (Condition):</td>
                            <td><span style="font-weight: 700; color: #dc2626;"><?= htmlspecialchars($data['product']->condition_status); ?></span> (Rất đẹp, đế còn mới)</td>
                        </tr>
                        <tr>
                            <td>Tình trạng kho:</td>
                            <td>
                                <?php if($data['product']->status == 'available'): ?>
                                    <span style="color: #16a34a; font-weight: 700;"><i class="fa-solid fa-circle-check me-1"></i> Còn hàng (Chỉ có 1 đôi duy nhất)</span>
                                <?php else: ?>
                                    <span style="color: #64748b; font-weight: 700;"><i class="fa-solid fa-circle-xmark me-1"></i> Đã bán</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>

                    <!-- Assurance Guarantee Box -->
                    <div class="guarantee-box">
                        <strong><i class="fa-solid fa-shield-halved me-1"></i> Cam kết từ 2Hand Kicks:</strong>
                        <ul>
                            <li>Bao check Auth trọn đời. Phát hiện fake hoàn tiền 200%.</li>
                            <li>Đã qua xử lý vệ sinh, dưỡng da và khử khuẩn tia cực tím UV.</li>
                            <li>Được mở hộp kiểm tra &amp; thử chân thoải mái trước khi thanh toán.</li>
                            <li>Hỗ trợ đổi mẫu trong vòng 48h nếu không vừa chân.</li>
                        </ul>
                    </div>

                    <!-- Description -->
                    <div class="detail-desc-box">
                        <strong style="display:block; margin-bottom: 6px; color: #0f172a;"><i class="fa-solid fa-circle-info text-primary me-1"></i> Mô tả chi tiết sản phẩm:</strong>
                        <?= nl2br(htmlspecialchars($data['product']->description)); ?>
                    </div>

                    <!-- Call To Action -->
                    <?php if($data['product']->status == 'available'): ?>
                        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                            <a href="<?= URLROOT; ?>/cart/add/<?= $data['product']->id; ?>" class="btn-add-cart-large">
                                <i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ hàng
                            </a>
                        </div>
                    <?php else: ?>
                        <button class="btn-add-cart-large" style="background: #94a3b8; cursor: not-allowed; box-shadow: none;" disabled>
                            <i class="fa-solid fa-lock me-1"></i> Sản phẩm đã có chủ sở hữu
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- RELATED PRODUCTS -->
        <?php if(!empty($data['related'])): ?>
            <div style="margin-top: 50px;">
                <h3 style="font-size: 22px; font-weight: 800; margin-bottom: 20px; color: #0f172a;">
                    <i class="fa-solid fa-shuffle text-danger me-2"></i> Có Thể Bạn Cũng Thích
                </h3>
                <div class="product-grid">
                    <?php foreach($data['related'] as $rel): ?>
                        <div class="product-card">
                            <div class="product-img-wrapper">
                                <a href="<?= URLROOT; ?>/product/detail/<?= $rel->slug; ?>">
                                    <img src="<?= htmlspecialchars($rel->image_url); ?>" alt="<?= htmlspecialchars($rel->name); ?>" loading="lazy">
                                </a>
                                <span class="card-badge-cond">Cond: <?= htmlspecialchars($rel->condition_status); ?></span>
                            </div>
                            <div class="product-card-body">
                                <div class="product-brand"><?= htmlspecialchars($rel->brand_name ?? 'Sneaker'); ?></div>
                                <h4 class="product-name">
                                    <a href="<?= URLROOT; ?>/product/detail/<?= $rel->slug; ?>">
                                        <?= htmlspecialchars($rel->name); ?>
                                    </a>
                                </h4>
                                <div class="product-specs">
                                    <span class="spec-badge">Size <?= htmlspecialchars($rel->size); ?></span>
                                </div>
                                <div class="product-footer-row">
                                    <div class="product-price"><?= number_format($rel->price, 0, ',', '.'); ?> đ</div>
                                    <a href="<?= URLROOT; ?>/product/detail/<?= $rel->slug; ?>" class="btn-add-cart-fast">Xem ngay</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
