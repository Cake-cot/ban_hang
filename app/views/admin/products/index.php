<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1"><i class="fas fa-shoe-prints text-primary me-2"></i> Quản lý Kho Giày</h2>
        <p class="text-muted small mb-0">Tổng cộng <?= count($data['products']); ?> sản phẩm trong hệ thống</p>
    </div>
    <a href="<?= URLROOT; ?>/admin/create_product" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Thêm Sản phẩm Mới
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th style="width: 70px;">Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Size</th>
                        <th>Độ mới</th>
                        <th>Giá bán</th>
                        <th>Trạng thái</th>
                        <th style="width: 220px;" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($data['products'])): ?>
                        <tr><td colspan="9" class="text-center py-4 text-muted">Chưa có sản phẩm nào</td></tr>
                    <?php else: ?>
                        <?php foreach($data['products'] as $p) : ?>
                        <tr>
                            <td class="fw-bold">#<?= $p->id; ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($p->image_url); ?>" width="55" height="55" style="object-fit: cover;" class="rounded border" alt="<?= htmlspecialchars($p->name); ?>">
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($p->name); ?></div>
                                <small class="text-muted"><i class="fas fa-tag me-1"></i> <?= htmlspecialchars($p->brand_name ?? 'Sneaker'); ?></small>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($p->category_name ?? 'Giày'); ?></span></td>
                            <td><span class="badge bg-secondary">Size <?= htmlspecialchars($p->size); ?></span></td>
                            <td><span class="fw-semibold text-danger"><?= htmlspecialchars($p->condition_status); ?></span></td>
                            <td class="fw-bold text-danger"><?= number_format($p->price, 0, ',', '.'); ?> đ</td>
                            <td>
                                <?php if($p->status == 'available'): ?>
                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i> Còn hàng</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><i class="fas fa-lock me-1"></i> Đã bán</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <?php if($p->status == 'available'): ?>
                                        <a href="<?= URLROOT; ?>/admin/update_status/<?= $p->id; ?>/sold" class="btn btn-outline-warning" title="Đánh dấu Đã Bán">
                                            <i class="fas fa-check"></i> Đã bán
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= URLROOT; ?>/admin/update_status/<?= $p->id; ?>/available" class="btn btn-outline-success" title="Mở lại kho">
                                            <i class="fas fa-rotate-left"></i> Mở lại
                                        </a>
                                    <?php endif; ?>

                                    <a href="<?= URLROOT; ?>/admin/edit_product/<?= $p->id; ?>" class="btn btn-outline-primary" title="Chỉnh sửa">
                                        <i class="fas fa-pen"></i> Sửa
                                    </a>

                                    <a href="<?= URLROOT; ?>/admin/delete_product/<?= $p->id; ?>" class="btn btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Thao tác không thể hoàn tác!');">
                                        <i class="fas fa-trash"></i>
                                    </a>
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
