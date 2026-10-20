<?php
class UserController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function login() {
        // Kiểm tra phương thức POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate CSRF token
            $this->validateCsrfToken($_POST['csrf_token'] ?? '');

            $data = [
                'email' => trim($_POST['email'] ?? ''),
                'password' => trim($_POST['password'] ?? ''),
                'email_err' => '',
                'password_err' => '',
                'csrf_token' => $this->generateCsrfToken()
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Vui lòng nhập email';
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Vui lòng nhập mật khẩu';
            }

            // Kiểm tra user có tồn tại ko
            if ($this->userModel->findUserByEmail($data['email'])) {
                // User found
            } else {
                $data['email_err'] = 'Không tìm thấy tài khoản';
            }

            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Sai mật khẩu';
                    $this->view('layout/header', ['title' => 'Đăng nhập']);
                    $this->view('user/login', $data);
                    $this->view('layout/footer');
                }
            } else {
                $this->view('layout/header', ['title' => 'Đăng nhập']);
                $this->view('user/login', $data);
                $this->view('layout/footer');
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
                'csrf_token' => $this->generateCsrfToken()
            ];

            $this->view('layout/header', ['title' => 'Đăng nhập']);
            $this->view('user/login', $data);
            $this->view('layout/footer');
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrfToken($_POST['csrf_token'] ?? '');

            $data = [
                'username' => trim($_POST['username'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'password' => trim($_POST['password'] ?? ''),
                'confirm_password' => trim($_POST['confirm_password'] ?? ''),
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'csrf_token' => $this->generateCsrfToken()
            ];

            if (empty($data['email'])) {
                $data['email_err'] = 'Vui lòng nhập email';
            } else {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email này đã được sử dụng';
                }
            }

            if (empty($data['username'])) {
                $data['username_err'] = 'Vui lòng nhập tên người dùng';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Vui lòng nhập mật khẩu';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Mật khẩu phải có ít nhất 6 ký tự';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Vui lòng xác nhận mật khẩu';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Mật khẩu không khớp';
                }
            }

            if (empty($data['email_err']) && empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Băm mật khẩu
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->userModel->register($data)) {
                    header('location: ' . URLROOT . '/user/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('layout/header', ['title' => 'Đăng ký']);
                $this->view('user/register', $data);
                $this->view('layout/footer');
            }
        } else {
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'csrf_token' => $this->generateCsrfToken()
            ];

            $this->view('layout/header', ['title' => 'Đăng ký']);
            $this->view('user/register', $data);
            $this->view('layout/footer');
        }
    }

    public function createUserSession($user) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->username;
        $_SESSION['user_role'] = $user->role;
        
        if($user->role == 'admin') {
            header('location: ' . URLROOT . '/admin');
        } else {
            header('location: ' . URLROOT);
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        header('location: ' . URLROOT . '/user/login');
    }

    public function orders() {
        if(!isset($_SESSION['user_id'])) {
            header('location: ' . URLROOT . '/user/login');
            exit;
        }

        $orderModel = $this->model('Order');
        $orders = $orderModel->getUserOrders($_SESSION['user_id']);
        foreach($orders as &$order) {
            $order->items = $orderModel->getOrderItems($order->id);
        }
        unset($order);

        $data = [
            'title' => 'Lịch sử Đơn hàng',
            'orders' => $orders
        ];

        $this->view('layout/header', $data);
        $this->view('user/orders', $data);
        $this->view('layout/footer');
    }
}
