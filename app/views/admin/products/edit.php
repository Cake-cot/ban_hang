<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 fw-bold"><i class="fas fa-edit text-primary me-2"></i> Chỉnh Sửa Sản Phẩm #<?= $data['product']->id; ?></h4>
            </div>
            <div class="card-body p-4">
                <form action="<?= URLROOT; ?>/admin/edit_product/<?= $data['product']->id; ?>" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tên sản phẩm *</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($data['product']->name); ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Giá bán (VNĐ) *</label>
                            <input type="number" name="price" class="form-control" value="<?= intval($data['product']->price); ?>" min="0" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Size (EU) *</label>
                            <input type="text" name="size" class="form-control" value="<?= htmlspecialchars($data['product']->size); ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Độ mới *</label>
                            <input type="text" name="condition_status" class="form-control" value="<?= htmlspecialchars($data['product']->condition_status); ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Danh mục *</label>
                            <select name="category_id" class="form-select" required>
                                <?php foreach($data['categories'] as $cat): ?>
                                    <option value="<?= $cat->id; ?>" <?= ($data['product']->category_id == $cat->id) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($cat->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Thương hiệu *</label>
                            <select name="brand_id" class="form-select" required>
                                <?php foreach($data['brands'] as $brand): ?>
                                    <option value="<?= $brand->id; ?>" <?= ($data['product']->brand_id == $brand->id) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($brand->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Trạng thái kho *</label>
                            <select name="status" class="form-select" required>
                                <option value="available" <?= ($data['product']->status == 'available') ? 'selected' : ''; ?>>Còn hàng</option>
                                <option value="sold" <?= ($data['product']->status == 'sold') ? 'selected' : ''; ?>>Đã bán</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">URL Ảnh sản phẩm *</label>
                        <div class="input-group">
                            <input type="url" name="image_url" class="form-control" value="<?= htmlspecialchars($data['product']->image_url); ?>" required>
                            <span class="input-group-text"><img src="<?= htmlspecialchars($data['product']->image_url); ?>" width="24" height="24" style="object-fit:cover;"></span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Mô tả chi tiết &amp; Tình trạng thực tế</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($data['product']->description); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= URLROOT; ?>/admin/products" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Cập Nhật Sản Phẩm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
