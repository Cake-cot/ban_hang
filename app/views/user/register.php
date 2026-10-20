    <!-- SUBPAGE HEADER -->
    <div class="subpage-header">
        <div class="container text-center">
            <h1 class="subpage-title">Đăng Ký Tài Khoản Mới</h1>
            <ul class="breadcrumb-custom" style="justify-content: center;">
                <li><a href="<?= URLROOT; ?>">Trang chủ</a></li>
                <li style="color: #dc2626;">Đăng ký</li>
            </ul>
        </div>
    </div>

    <!-- MAIN REGISTER FORM -->
    <div class="container">
        <div class="auth-wrapper">
            <div class="auth-card">
                <h2 class="auth-title">Tham Gia Cùng 2Hand Kicks</h2>
                <p class="auth-subtitle">Tạo tài khoản để săn giày hiệu chính hãng với giá sinh viên.</p>

                <form action="<?= URLROOT; ?>/user/register" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $data['csrf_token'] ?? ($_SESSION['csrf_token'] ?? ''); ?>">

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label for="username"><i class="fa-regular fa-user me-1 text-danger"></i> Tên người dùng / Biệt danh</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($data['username'] ?? ''); ?>" placeholder="VD: sneakerhead_vietnam" required>
                        <?php if(!empty($data['username_err'])): ?>
                            <span style="color: #dc2626; font-size: 13px; font-weight: 500; display: block; margin-top: 4px;">
                                <i class="fa-solid fa-circle-exclamation me-1"></i> <?= $data['username_err']; ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label for="email"><i class="fa-regular fa-envelope me-1 text-danger"></i> Địa chỉ Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($data['email'] ?? ''); ?>" placeholder="name@example.com" required>
                        <?php if(!empty($data['email_err'])): ?>
                            <span style="color: #dc2626; font-size: 13px; font-weight: 500; display: block; margin-top: 4px;">
                                <i class="fa-solid fa-circle-exclamation me-1"></i> <?= $data['email_err']; ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label for="password"><i class="fa-solid fa-lock me-1 text-danger"></i> Mật khẩu (tối thiểu 6 ký tự)</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                        <?php if(!empty($data['password_err'])): ?>
                            <span style="color: #dc2626; font-size: 13px; font-weight: 500; display: block; margin-top: 4px;">
                                <i class="fa-solid fa-circle-exclamation me-1"></i> <?= $data['password_err']; ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group" style="margin-bottom: 22px;">
                        <label for="confirm_password"><i class="fa-solid fa-shield-check me-1 text-danger"></i> Xác nhận mật khẩu</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="••••••••" required>
                        <?php if(!empty($data['confirm_password_err'])): ?>
                            <span style="color: #dc2626; font-size: 13px; font-weight: 500; display: block; margin-top: 4px;">
                                <i class="fa-solid fa-circle-exclamation me-1"></i> <?= $data['confirm_password_err']; ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn-primary-block">
                        <i class="fa-solid fa-user-plus me-2"></i> Hoàn Tất Đăng Ký
                    </button>

                    <div style="text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #e2e8f0; font-size: 14px; color: #64748b;">
                        Đã có tài khoản từ trước? <a href="<?= URLROOT; ?>/user/login" style="color: #dc2626; font-weight: 700;">Đăng nhập tại đây</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
