    <!-- SUBPAGE HEADER -->
    <div class="subpage-header">
        <div class="container">
            <h1 class="subpage-title">Lịch Sử Đơn Hàng Của Bạn</h1>
            <ul class="breadcrumb-custom">
                <li><a href="<?= URLROOT; ?>">Trang chủ</a></li>
                <li style="color: #dc2626;">Đơn hàng của tôi</li>
            </ul>
        </div>
    </div>

    <!-- MAIN ORDERS CONTENT -->
    <div class="container" style="padding-bottom: 60px;">
        <?php if(empty($data['orders'])) : ?>
            <div class="cart-card" style="text-align: center; padding: 70px 20px;">
                <i class="fa-solid fa-box-open" style="font-size: 50px; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h3 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Bạn chưa có đơn hàng nào</h3>
                <p style="color: #64748b; font-size: 14px; margin-bottom: 25px;">Hãy dạo qua các bộ sưu tập giày si hiệu để tìm cho mình đôi giày ưng ý nhất nhé!</p>
                <a href="<?= URLROOT; ?>" class="btn-add-cart-large">
                    <i class="fa-solid fa-shoe-prints me-2"></i> Khám phá sản phẩm ngay
                </a>
            </div>
        <?php else : ?>
            <div class="row">
                <div class="col-md-12">
                    <?php foreach($data['orders'] as $order): ?>
                        <div class="cart-card" style="margin-bottom: 25px; border-left: 4px solid #dc2626;">
                            <!-- Order Header -->
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; padding-bottom: 15px; border-bottom: 1px solid #e2e8f0; margin-bottom: 15px;">
                                <div>
                                    <span style="font-size: 16px; font-weight: 800; color: #0f172a;">
                                        <i class="fa-solid fa-receipt text-danger me-1"></i> Đơn hàng #<?= $order->id; ?>
                                    </span>
                                    <span style="color: #64748b; font-size: 13px; margin-left: 10px;">
                                        <i class="fa-regular fa-clock me-1"></i> <?= date('d/m/Y - H:i', strtotime($order->created_at)); ?>
                                    </span>
                                </div>
                                
                                <div>
                                    <?php
                                        $statusBadges = [
                                            'pending' => '<span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;"><i class="fa-solid fa-hourglass-half me-1"></i> Chờ xử lý</span>',
                                            'processing' => '<span style="background: #e0f2fe; color: #075985; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;"><i class="fa-solid fa-gear me-1"></i> Đang chuẩn bị hàng</span>',
                                            'shipped' => '<span style="background: #dbeafe; color: #1e40af; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;"><i class="fa-solid fa-truck-fast me-1"></i> Đang giao hàng</span>',
                                            'completed' => '<span style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;"><i class="fa-solid fa-circle-check me-1"></i> Đã hoàn thành</span>',
                                            'cancelled' => '<span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;"><i class="fa-solid fa-circle-xmark me-1"></i> Đã hủy</span>',
                                        ];
                                        echo $statusBadges[$order->status] ?? $order->status;
                                    ?>
                                </div>
                            </div>

                            <!-- Shipping info -->
                            <div style="font-size: 13px; color: #475569; margin-bottom: 15px; background: #f8fafc; padding: 10px 14px; border-radius: 6px;">
                                <i class="fa-solid fa-location-dot text-danger me-1"></i> <strong>Địa chỉ nhận hàng:</strong> <?= htmlspecialchars($order->shipping_address); ?>
                            </div>

                            <!-- Items in Order -->
                            <?php if(!empty($order->items)): ?>
                                <div style="margin-bottom: 15px;">
                                    <?php foreach($order->items as $item): ?>
                                        <div style="display: flex; align-items: center; gap: 14px; padding: 10px 0; border-bottom: 1px dashed #f1f5f9;">
                                            <img src="<?= htmlspecialchars($item->image_url); ?>" alt="<?= htmlspecialchars($item->name); ?>" style="width: 55px; height: 55px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;">
                                            <div style="flex-grow: 1;">
                                                <div style="font-weight: 700; font-size: 14px; color: #0f172a;">
                                                    <a href="<?= URLROOT; ?>/product/detail/<?= $item->slug; ?>"><?= htmlspecialchars($item->name); ?></a>
                                                </div>
                                                <div style="font-size: 12px; color: #64748b;">
                                                    <span class="spec-badge">Size <?= htmlspecialchars($item->size); ?></span>
                                                    <span class="spec-badge">Cond: <?= htmlspecialchars($item->condition_status); ?></span>
                                                </div>
                                            </div>
                                            <div style="font-weight: 700; color: #0f172a; font-size: 14px;">
                                                <?= number_format($item->price, 0, ',', '.'); ?> đ
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Order Footer Total -->
                            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 15px; padding-top: 10px; border-top: 1px solid #e2e8f0;">
                                <span style="font-size: 14px; color: #64748b;">Tổng tiền thanh toán (COD):</span>
                                <span style="font-size: 20px; font-weight: 800; color: #dc2626;">
                                    <?= number_format($order->total_amount, 0, ',', '.'); ?> đ
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
