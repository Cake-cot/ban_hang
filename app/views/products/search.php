    <!-- SUBPAGE HEADER -->
    <div class="subpage-header">
        <div class="container">
            <h1 class="subpage-title">
                <?php if(!empty($data['keyword'])): ?>
                    Kết quả tìm kiếm: "<?= htmlspecialchars($data['keyword']); ?>"
                <?php else: ?>
                    Tất cả sản phẩm giày si
                <?php endif; ?>
            </h1>
            <ul class="breadcrumb-custom">
                <li><a href="<?= URLROOT; ?>">Trang chủ</a></li>
                <li>Tìm kiếm &amp; Lọc sản phẩm</li>
            </ul>
        </div>
    </div>

    <!-- MAIN PRODUCT SECTION -->
    <div class="container" style="padding-bottom: 50px;">
        
        <!-- SEARCH & FILTER TOOLBAR -->
        <div class="filter-toolbar">
            <!-- Category Pills -->
            <div class="category-pills">
                <a href="<?= URLROOT; ?>/product/search" class="cat-pill <?= empty($data['current_category']) ? 'active' : ''; ?>">
                    <i class="fa-solid fa-border-all me-1"></i> Tất cả
                </a>
                <?php foreach($data['categories'] as $cat): ?>
                    <a href="<?= URLROOT; ?>/product/search?category=<?= $cat->slug; ?><?= !empty($data['keyword']) ? '&q='.urlencode($data['keyword']) : ''; ?>" class="cat-pill <?= (isset($data['current_category']) && $data['current_category'] == $cat->slug) ? 'active' : ''; ?>">
                        <?= htmlspecialchars($cat->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Filter By Brand / Size / Sort Form -->
            <form action="<?= URLROOT; ?>/product/search" method="GET" class="filter-selects">
                <?php if(!empty($data['keyword'])): ?>
                    <input type="hidden" name="q" value="<?= htmlspecialchars($data['keyword']); ?>">
                <?php endif; ?>
                <?php if(!empty($data['current_category'])): ?>
                    <input type="hidden" name="category" value="<?= htmlspecialchars($data['current_category']); ?>">
                <?php endif; ?>

                <!-- Brand Filter -->
                <select name="brand" class="filter-select" onchange="this.form.submit()">
                    <option value="">-- Tất cả Hãng --</option>
                    <?php foreach($data['brands'] as $b): ?>
                        <option value="<?= $b->slug; ?>" <?= (isset($data['current_brand']) && $data['current_brand'] == $b->slug) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($b->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Size Filter -->
                <select name="size" class="filter-select" onchange="this.form.submit()">
                    <option value="">-- Size --</option>
                    <?php foreach($data['sizes'] as $s): ?>
                        <option value="<?= $s->size; ?>" <?= (isset($data['current_size']) && $data['current_size'] == $s->size) ? 'selected' : ''; ?>>
                            Size <?= htmlspecialchars($s->size); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Sort Filter -->
                <select name="sort" class="filter-select" onchange="this.form.submit()">
                    <option value="newest" <?= (isset($data['current_sort']) && $data['current_sort'] == 'newest') ? 'selected' : ''; ?>>Mới nhất</option>
                    <option value="price_asc" <?= (isset($data['current_sort']) && $data['current_sort'] == 'price_asc') ? 'selected' : ''; ?>>Giá: Thấp đến Cao</option>
                    <option value="price_desc" <?= (isset($data['current_sort']) && $data['current_sort'] == 'price_desc') ? 'selected' : ''; ?>>Giá: Cao đến Thấp</option>
                </select>
            </form>
        </div>

        <!-- SECTION HEADING -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 25px;">
            <div>
                <p style="color: #64748b; margin: 0; font-size: 14px;">
                    Tìm thấy <strong style="color: #dc2626;"><?= count($data['products']); ?></strong> đôi giày khớp với yêu cầu của bạn.
                </p>
            </div>
            <?php if(!empty($data['keyword']) || !empty($data['current_category']) || !empty($data['current_brand']) || !empty($data['current_size'])): ?>
                <a href="<?= URLROOT; ?>/product/search" style="font-size: 13px; color: #dc2626; font-weight: 600;">
                    <i class="fa-solid fa-rotate-right me-1"></i> Xóa tất cả bộ lọc
                </a>
            <?php endif; ?>
        </div>

        <!-- PRODUCT GRID -->
        <?php if(empty($data['products'])): ?>
            <div style="text-align: center; padding: 60px 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0;">
                <i class="fa-solid fa-magnifying-glass" style="font-size: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                <h3 style="font-size: 20px; font-weight: 700; color: #0f172a;">Không tìm thấy sản phẩm phù hợp</h3>
                <p style="color: #64748b; font-size: 14px; margin-bottom: 20px;">Vui lòng kiểm tra lại từ khóa hoặc xóa bớt tiêu chí lọc.</p>
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
