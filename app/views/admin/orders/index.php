<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1"><i class="fas fa-shopping-bag text-primary me-2"></i> Quản lý Đơn hàng</h2>
        <p class="text-muted small mb-0">Theo dõi, duyệt và xử lý các giao dịch khách hàng</p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 70px;">Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Địa chỉ giao hàng</th>
                        <th>Tổng tiền</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th style="width: 180px;" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($data['orders'])): ?>
                        <tr><td colspan="7" class="text-center py-4 text-muted">Chưa có đơn hàng nào</td></tr>
                    <?php else: ?>
                        <?php foreach($data['orders'] as $o) : ?>
                        <tr>
                            <td class="fw-bold">#<?= $o->id; ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($o->username); ?></div>
                                <small class="text-muted"><i class="fas fa-envelope me-1"></i> <?= htmlspecialchars($o->email); ?></small>
                            </td>
                            <td>
                                <div class="small text-truncate" style="max-width: 250px;" title="<?= htmlspecialchars($o->shipping_address); ?>">
                                    <i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($o->shipping_address); ?>
                                </div>
                            </td>
                            <td class="text-danger fw-bold fs-6"><?= number_format($o->total_amount, 0, ',', '.'); ?> đ</td>
                            <td class="small text-muted"><?= date('d/m/Y - H:i', strtotime($o->created_at)); ?></td>
                            <td>
                                <?php 
                                    $badges = [
                                        'pending' => 'bg-warning text-dark',
                                        'processing' => 'bg-info text-dark',
                                        'shipped' => 'bg-primary',
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger'
                                    ];
                                    $statusText = [
                                        'pending' => 'Chờ xử lý',
                                        'processing' => 'Đang chuẩn bị',
                                        'shipped' => 'Đang giao hàng',
                                        'completed' => 'Hoàn thành',
                                        'cancelled' => 'Đã hủy'
                                    ];
                                ?>
                                <span class="badge <?= $badges[$o->status] ?? 'bg-secondary'; ?>">
                                    <?= $statusText[$o->status] ?? $o->status; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="<?= URLROOT; ?>/admin/order_detail/<?= $o->id; ?>" class="btn btn-sm btn-outline-primary" title="Xem chi tiết đơn">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>

                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Đổi trạng thái
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li><a class="dropdown-item" href="<?= URLROOT; ?>/admin/update_order/<?= $o->id; ?>/pending"><i class="fas fa-hourglass-half text-warning me-2"></i> Chờ xử lý</a></li>
                                            <li><a class="dropdown-item" href="<?= URLROOT; ?>/admin/update_order/<?= $o->id; ?>/processing"><i class="fas fa-gear text-info me-2"></i> Đang chuẩn bị</a></li>
                                            <li><a class="dropdown-item" href="<?= URLROOT; ?>/admin/update_order/<?= $o->id; ?>/shipped"><i class="fas fa-truck text-primary me-2"></i> Đang giao hàng</a></li>
                                            <li><a class="dropdown-item" href="<?= URLROOT; ?>/admin/update_order/<?= $o->id; ?>/completed"><i class="fas fa-check-circle text-success me-2"></i> Hoàn thành</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="<?= URLROOT; ?>/admin/update_order/<?= $o->id; ?>/cancelled" onclick="return confirm('Bạn có chắc muốn hủy đơn này?');"><i class="fas fa-times-circle me-2"></i> Hủy đơn</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
