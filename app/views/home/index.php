    <!-- HERO BANNER -->
    <section class="hero-banner-section">
        <div class="container">
            <h1 class="hero-title">Săn Giày Hiệu Secondhand <span>-</span> Giá Sinh Viên</h1>
            <p class="hero-subtitle">
                Tuyển chọn các siêu phẩm Nike, Adidas, Jordan, Converse, Vans... độ mới cao từ 85% đến 98%, đã qua quy trình vệ sinh diệt khuẩn chuyên sâu và cam kết Auth trọn đời.
            </p>
            <div class="hero-badges">
                <div class="hero-badge-item">
                    <i class="fa-solid fa-circle-check text-success"></i> 100% Ảnh chụp thật không qua chỉnh sửa
                </div>
                <div class="hero-badge-item">
                    <i class="fa-solid fa-shield-virus text-info"></i> Vệ sinh &amp; Khử mùi ozone chuyên nghiệp
                </div>
                <div class="hero-badge-item">
                    <i class="fa-solid fa-box-open text-warning"></i> Được đồng kiểm trước khi thanh toán
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN PRODUCT SECTION -->
    <div class="container" style="padding-top: 35px; padding-bottom: 50px;">
        
        <!-- FILTER TOOLBAR -->
        <div class="filter-toolbar">
            <!-- Category Pills -->
            <div class="category-pills">
                <a href="<?= URLROOT; ?>" class="cat-pill <?= empty($data['current_category']) ? 'active' : ''; ?>">
                    <i class="fa-solid fa-border-all me-1"></i> Tất cả
                </a>
                <?php foreach($data['categories'] as $cat): ?>
                    <a href="<?= URLROOT; ?>/product/category/<?= $cat->slug; ?>" class="cat-pill <?= (isset($data['current_category']) && $data['current_category'] == $cat->slug) ? 'active' : ''; ?>">
                        <?= htmlspecialchars($cat->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Filter By Brand / Size / Sort Form -->
            <form action="<?= URLROOT; ?>/product/search" method="GET" class="filter-selects">
                <!-- Brand Filter -->
                <select name="brand" class="filter-select" onchange="this.form.submit()">
                    <option value="">-- Tất cả Hãng --</option>
                    <?php foreach($data['brands'] as $b): ?>
                        <option value="<?= $b->slug; ?>" <?= (isset($_GET['brand']) && $_GET['brand'] == $b->slug) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($b->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Size Filter -->
                <select name="size" class="filter-select" onchange="this.form.submit()">
                    <option value="">-- Size --</option>
                    <?php foreach($data['sizes'] as $s): ?>
                        <option value="<?= $s->size; ?>" <?= (isset($_GET['size']) && $_GET['size'] == $s->size) ? 'selected' : ''; ?>>
                            Size <?= htmlspecialchars($s->size); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Sort Filter -->
                <select name="sort" class="filter-select" onchange="this.form.submit()">
                    <option value="newest" <?= (isset($_GET['sort']) && $_GET['sort'] == 'newest') ? 'selected' : ''; ?>>Mới nhất</option>
                    <option value="price_asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : ''; ?>>Giá: Thấp đến Cao</option>
                    <option value="price_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : ''; ?>>Giá: Cao đến Thấp</option>
                </select>
            </form>
        </div>

        <!-- SECTION HEADING -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 25px;">
            <div>
                <h2 style="font-size: 24px; font-weight: 800; margin: 0 0 6px 0; color: #0f172a;">
                    <i class="fa-solid fa-shoe-prints text-danger me-2"></i> Giày Mới Lên Kệ
                </h2>
                <p style="color: #64748b; margin: 0; font-size: 14px;">Mỗi mẫu là phiên bản độc nhất chỉ có duy nhất 1 đôi duy nhất.</p>
            </div>
            <span style="font-size: 13px; font-weight: 600; color: #64748b; background: #f1f5f9; padding: 4px 10px; border-radius: 20px;">
                Hiển thị <?= count($data['products']); ?> sản phẩm
            </span>
        </div>

        <!-- PRODUCT GRID -->
        <?php if(empty($data['products'])): ?>
            <div style="text-align: center; padding: 60px 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0;">
                <i class="fa-solid fa-box-open" style="font-size: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                <h3 style="font-size: 20px; font-weight: 700; color: #0f172a;">Chưa có sản phẩm nào phù hợp</h3>
                <p style="color: #64748b; font-size: 14px; margin-bottom: 20px;">Hãy thử chọn bộ lọc khác hoặc quay lại danh mục tất cả.</p>
                <a href="<?= URLROOT; ?>" class="btn-add-cart-fast" style="display: inline-block; padding: 8px 20px;">Xem tất cả giày</a>
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach($data['products'] as $product): ?>
                    <div class="product-card">
                        <!-- Image Container -->
                        <div class="product-img-wrapper">
                            <a href="<?= URLROOT; ?>/product/detail/<?= $product->slug; ?>">
                                <img src="<?= htmlspecialchars($product->image_url); ?>" alt="<?= htmlspecialchars($product->name); ?>" loading="lazy">
                            </a>
                            <span class="card-badge-cond">Cond: <?= htmlspecialchars($product->condition_status); ?></span>
                            <?php if($product->status === 'available'): ?>
                                <span class="card-badge-status available">Còn hàng</span>
                            <?php else: ?>
                                <span class="card-badge-status sold">Đã bán</span>
                            <?php endif; ?>
                        </div>

                        <!-- Card Body -->
                        <div class="product-card-body">
                            <div class="product-brand"><?= htmlspecialchars($product->brand_name ?? 'Sneaker'); ?></div>
                            <h3 class="product-name">
                                <a href="<?= URLROOT; ?>/product/detail/<?= $product->slug; ?>" title="<?= htmlspecialchars($product->name); ?>">
                                    <?= htmlspecialchars($product->name); ?>
                                </a>
                            </h3>

                            <div class="product-specs">
                                <span class="spec-badge"><i class="fa-solid fa-ruler me-1"></i> Size <?= htmlspecialchars($product->size); ?></span>
                                <span class="spec-badge" style="background: #fef2f2; color: #dc2626;"><?= htmlspecialchars($product->category_name ?? 'Giày'); ?></span>
                            </div>

                            <div class="product-footer-row">
                                <div class="product-price">
                                    <?= number_format($product->price, 0, ',', '.'); ?> <small style="font-size: 13px; font-weight: normal;">đ</small>
                                </div>
                                <?php if($product->status === 'available'): ?>
                                    <a href="<?= URLROOT; ?>/cart/add/<?= $product->id; ?>" class="btn-add-cart-fast" title="Thêm vào giỏ">
                                        <i class="fa-solid fa-cart-plus"></i> Chọn mua
                                    </a>
                                <?php else: ?>
                                    <span class="btn-add-cart-fast disabled"><i class="fa-solid fa-check"></i> Hết hàng</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
