<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-gauge-high text-primary me-2"></i> Tổng quan hệ thống</h2>
    <a href="<?= URLROOT; ?>/admin/create_product" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Thêm giày mới
    </a>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm border-0 border-start border-primary border-4 h-100">
            <div class="card-body">
                <div class="text-muted small fw-semibold text-uppercase">Kho sản phẩm</div>
                <div class="fs-2 fw-bold text-dark mt-1"><?= $data['total_products']; ?></div>
                <div class="small text-muted mt-2">
                    <span class="text-success fw-bold"><?= $data['available_products']; ?> còn hàng</span> | 
                    <span class="text-secondary"><?= $data['sold_products']; ?> đã bán</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm border-0 border-start border-success border-4 h-100">
            <div class="card-body">
                <div class="text-muted small fw-semibold text-uppercase">Doanh thu ghi nhận</div>
                <div class="fs-2 fw-bold text-success mt-1"><?= number_format($data['total_revenue'], 0, ',', '.'); ?> đ</div>
                <div class="small text-muted mt-2">Từ các đơn hàng thành công</div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm border-0 border-start border-warning border-4 h-100">
            <div class="card-body">
                <div class="text-muted small fw-semibold text-uppercase">Tổng số đơn hàng</div>
                <div class="fs-2 fw-bold text-dark mt-1"><?= $data['total_orders']; ?></div>
                <div class="small text-muted mt-2">
                    <?php if($data['pending_orders'] > 0): ?>
                        <span class="text-danger fw-bold"><i class="fas fa-bell me-1"></i> <?= $data['pending_orders']; ?> đơn chờ duyệt</span>
                    <?php else: ?>
                        <span class="text-success">Tất cả đã xử lý</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm border-0 border-start border-info border-4 h-100">
            <div class="card-body">
                <div class="text-muted small fw-semibold text-uppercase">Trạng thái hệ thống</div>
                <div class="fs-4 fw-bold text-info mt-1"><i class="fas fa-circle-check text-success me-1"></i> Hoạt động tốt</div>
                <div class="small text-muted mt-2">PHP 8.2 &bull; MySQL UTF-8</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Recent Products -->
<div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-shopping-bag text-primary me-2"></i> Đơn hàng gần đây</h5>
                <a href="<?= URLROOT; ?>/admin/orders" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã ĐH</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($data['recent_orders'])): ?>
                                <tr><td colspan="5" class="text-center py-4 text-muted">Chưa có đơn hàng nào</td></tr>
                            <?php else: ?>
                                <?php foreach($data['recent_orders'] as $ro): ?>
                                    <tr>
                                        <td class="fw-bold">#<?= $ro->id; ?></td>
                                        <td>
                                            <div class="fw-semibold"><?= htmlspecialchars($ro->username); ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($ro->email); ?></small>
                                        </td>
                                        <td class="fw-bold text-danger"><?= number_format($ro->total_amount, 0, ',', '.'); ?> đ</td>
                                        <td>
                                            <?php
                                                $badges = [
                                                    'pending' => 'bg-warning text-dark',
                                                    'processing' => 'bg-info text-dark',
                                                    'shipped' => 'bg-primary',
                                                    'completed' => 'bg-success',
                                                    'cancelled' => 'bg-danger'
                                                ];
                                                $labels = [
                                                    'pending' => 'Chờ xử lý',
                                                    'processing' => 'Đang xử lý',
                                                    'shipped' => 'Đang giao',
                                                    'completed' => 'Hoàn thành',
                                                    'cancelled' => 'Đã hủy'
                                                ];
                                            ?>
                                            <span class="badge <?= $badges[$ro->status] ?? 'bg-secondary'; ?>">
                                                <?= $labels[$ro->status] ?? $ro->status; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= URLROOT; ?>/admin/order_detail/<?= $ro->id; ?>" class="btn btn-sm btn-light border">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-shoe-prints text-danger me-2"></i> Giày mới cập nhật</h5>
                <a href="<?= URLROOT; ?>/admin/products" class="btn btn-sm btn-outline-danger">Xem kho</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php if(empty($data['recent_products'])): ?>
                        <li class="list-group-item text-center py-4 text-muted">Chưa có sản phẩm nào</li>
                    <?php else: ?>
                        <?php foreach($data['recent_products'] as $rp): ?>
                            <li class="list-group-item d-flex align-items-center justify-content-between py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="<?= htmlspecialchars($rp->image_url); ?>" width="45" height="45" class="rounded object-fit-cover border" alt="<?= htmlspecialchars($rp->name); ?>">
                                    <div>
                                        <div class="fw-bold text-dark small text-truncate" style="max-width: 180px;">
                                            <?= htmlspecialchars($rp->name); ?>
                                        </div>
                                        <div class="text-muted small">Size <?= htmlspecialchars($rp->size); ?> &bull; Cond <?= htmlspecialchars($rp->condition_status); ?></div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-danger small"><?= number_format($rp->price, 0, ',', '.'); ?> đ</div>
                                    <?php if($rp->status === 'available'): ?>
                                        <span class="badge bg-success small">Còn hàng</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary small">Đã bán</span>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
