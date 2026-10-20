<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 fw-bold"><i class="fas fa-plus-circle text-primary me-2"></i> Thêm Sản Phẩm Giày Mới</h4>
            </div>
            <div class="card-body p-4">
                <form action="<?= URLROOT; ?>/admin/create_product" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tên sản phẩm *</label>
                            <input type="text" name="name" class="form-control" placeholder="VD: Nike Air Jordan 1 High Chicago" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Giá bán (VNĐ) *</label>
                            <input type="number" name="price" class="form-control" placeholder="VD: 2500000" min="0" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Size (EU) *</label>
                            <input type="text" name="size" class="form-control" placeholder="VD: 42" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Độ mới (VD: 9.5/10) *</label>
                            <input type="text" name="condition_status" class="form-control" placeholder="VD: 9.5/10 Like New" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Danh mục *</label>
                            <select name="category_id" class="form-select" required>
                                <?php foreach($data['categories'] as $cat): ?>
                                    <option value="<?= $cat->id; ?>"><?= htmlspecialchars($cat->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Thương hiệu *</label>
                            <select name="brand_id" class="form-select" required>
                                <?php foreach($data['brands'] as $brand): ?>
                                    <option value="<?= $brand->id; ?>"><?= htmlspecialchars($brand->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">URL Ảnh sản phẩm *</label>
                        <input type="url" name="image_url" class="form-control" placeholder="https://images.unsplash.com/..." required>
                        <div class="form-text">Nhập đường dẫn trực tiếp đến file ảnh (Unsplash, Imgur, Cloudinary...).</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Mô tả chi tiết &amp; Tình trạng thực tế</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Mô tả phụ kiện đi kèm (box, dây), vết xước nhẹ nếu có, cam kết authentic..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= URLROOT; ?>/admin/products" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Lưu &amp; Đăng Bán
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
