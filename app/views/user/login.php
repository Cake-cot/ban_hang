    <!-- SUBPAGE HEADER -->
    <div class="subpage-header">
        <div class="container text-center">
            <h1 class="subpage-title">Đăng Nhập Tài Khoản</h1>
            <ul class="breadcrumb-custom" style="justify-content: center;">
                <li><a href="<?= URLROOT; ?>">Trang chủ</a></li>
                <li style="color: #dc2626;">Đăng nhập</li>
            </ul>
        </div>
    </div>

    <!-- MAIN LOGIN FORM -->
    <div class="container">
        <div class="auth-wrapper">
            <div class="auth-card">
                <h2 class="auth-title">Chào Mừng Trở Lại!</h2>
                <p class="auth-subtitle">Đăng nhập để theo dõi đơn hàng và lưu giỏ hàng của bạn.</p>

                <form action="<?= URLROOT; ?>/user/login" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $data['csrf_token'] ?? ($_SESSION['csrf_token'] ?? ''); ?>">

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label for="email"><i class="fa-regular fa-envelope me-1 text-danger"></i> Địa chỉ Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($data['email'] ?? ''); ?>" placeholder="name@example.com" required>
                        <?php if(!empty($data['email_err'])): ?>
                            <span style="color: #dc2626; font-size: 13px; font-weight: 500; display: block; margin-top: 4px;">
                                <i class="fa-solid fa-circle-exclamation me-1"></i> <?= $data['email_err']; ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group" style="margin-bottom: 22px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <label for="password" style="margin: 0;"><i class="fa-solid fa-lock me-1 text-danger"></i> Mật khẩu</label>
                        </div>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                        <?php if(!empty($data['password_err'])): ?>
                            <span style="color: #dc2626; font-size: 13px; font-weight: 500; display: block; margin-top: 4px;">
                                <i class="fa-solid fa-circle-exclamation me-1"></i> <?= $data['password_err']; ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn-primary-block">
                        <i class="fa-solid fa-arrow-right-to-bracket me-2"></i> Đăng Nhập
                    </button>

                    <div style="text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #e2e8f0; font-size: 14px; color: #64748b;">
                        Bạn chưa có tài khoản? <a href="<?= URLROOT; ?>/user/register" style="color: #dc2626; font-weight: 700;">Đăng ký thành viên</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
