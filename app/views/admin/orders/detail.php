<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1"><i class="fas fa-file-invoice text-primary me-2"></i> Chi Tiết Đơn Hàng #<?= $data['order']->id; ?></h2>
        <p class="text-muted small mb-0">Đặt ngày: <?= date('d/m/Y - H:i', strtotime($data['order']->created_at)); ?></p>
    </div>
    <a href="<?= URLROOT; ?>/admin/orders" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
    </a>
</div>

<div class="row g-4">
    <!-- Left: Order Items Table -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-shoe-prints text-danger me-2"></i> Danh sách giày trong đơn hàng</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 70px;">Ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Size</th>
                                <th>Tình trạng</th>
                                <th class="text-end">Đơn giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['items'] as $item): ?>
                                <tr>
                                    <td>
                                        <img src="<?= htmlspecialchars($item->image_url); ?>" width="55" height="55" class="rounded border object-fit-cover" alt="<?= htmlspecialchars($item->name); ?>">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($item->name); ?></div>
                                        <a href="<?= URLROOT; ?>/product/detail/<?= $item->slug; ?>" target="_blank" class="small text-primary">Xem link sản phẩm <i class="fas fa-external-link-alt"></i></a>
                                    </td>
                                    <td><span class="badge bg-secondary">Size <?= htmlspecialchars($item->size); ?></span></td>
                                    <td><span class="text-danger fw-semibold"><?= htmlspecialchars($item->condition_status); ?></span></td>
                                    <td class="text-end fw-bold text-danger"><?= number_format($item->price, 0, ',', '.'); ?> đ</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end">Tổng tiền đơn hàng:</th>
                                <th class="text-end fs-5 text-danger fw-bold"><?= number_format($data['order']->total_amount, 0, ',', '.'); ?> đ</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Customer Info & Status Action -->
    <div class="col-lg-4">
        <!-- Customer Info Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-user text-primary me-2"></i> Thông tin khách hàng</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="text-muted small">Tên tài khoản:</div>
                    <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($data['order']->username); ?></div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small">Email liên hệ:</div>
                    <div class="fw-semibold text-dark"><?= htmlspecialchars($data['order']->email); ?></div>
                </div>
                <div>
                    <div class="text-muted small">Địa chỉ nhận hàng (Giao tận nơi):</div>
                    <div class="fw-semibold text-dark p-2 bg-light rounded border mt-1">
                        <i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($data['order']->shipping_address); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Update Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-tasks text-success me-2"></i> Trạng thái giao dịch</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span class="text-muted small d-block mb-1">Trạng thái hiện tại:</span>
                    <?php 
                        $statusText = [
                            'pending' => 'Chờ xử lý',
                            'processing' => 'Đang chuẩn bị hàng',
                            'shipped' => 'Đang giao hàng',
                            'completed' => 'Đã hoàn thành',
                            'cancelled' => 'Đã hủy'
                        ];
                        $badges = [
                            'pending' => 'bg-warning text-dark',
                            'processing' => 'bg-info text-dark',
                            'shipped' => 'bg-primary',
                            'completed' => 'bg-success',
                            'cancelled' => 'bg-danger'
                        ];
                    ?>
                    <span class="badge <?= $badges[$data['order']->status] ?? 'bg-secondary'; ?> fs-6 p-2">
                        <?= $statusText[$data['order']->status] ?? $data['order']->status; ?>
                    </span>
                </div>

                <div class="dropdown w-100">
                    <button class="btn btn-outline-dark dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                        Cập nhật trạng thái mới
                    </button>
                    <ul class="dropdown-menu w-100 shadow">
                        <li><a class="dropdown-item" href="<?= URLROOT; ?>/admin/update_order/<?= $data['order']->id; ?>/pending">Chờ xử lý</a></li>
                        <li><a class="dropdown-item" href="<?= URLROOT; ?>/admin/update_order/<?= $data['order']->id; ?>/processing">Đang chuẩn bị</a></li>
                        <li><a class="dropdown-item" href="<?= URLROOT; ?>/admin/update_order/<?= $data['order']->id; ?>/shipped">Đang giao hàng</a></li>
                        <li><a class="dropdown-item" href="<?= URLROOT; ?>/admin/update_order/<?= $data['order']->id; ?>/completed">Hoàn thành</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= URLROOT; ?>/admin/update_order/<?= $data['order']->id; ?>/cancelled" onclick="return confirm('Xác nhận hủy đơn hàng này?');">Hủy đơn</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
