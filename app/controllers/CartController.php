<?php
class CartController extends Controller {
    private $productModel;
    private $orderModel;

    public function __construct() {
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $this->productModel = $this->model('Product');
        $this->orderModel = $this->model('Order');
    }

    public function index() {
        $cart_items = [];
        $total = 0;
        
        foreach($_SESSION['cart'] as $id) {
            $product = $this->productModel->getProductById($id);
            if($product && $product->status == 'available') {
                $cart_items[] = $product;
                $total += $product->price;
            } else {
                // Xóa khỏi giỏ nếu đã bán
                $this->remove($id, false);
            }
        }

        $data = [
            'title' => 'Giỏ hàng của bạn',
            'items' => $cart_items,
            'total' => $total,
            'csrf_token' => $this->generateCsrfToken()
        ];

        $this->view('layout/header', $data);
        $this->view('cart/index', $data);
        $this->view('layout/footer');
    }

    public function add($id) {
        $product = $this->productModel->getProductById($id);
        if($product && $product->status == 'available') {
            if(!in_array($id, $_SESSION['cart'])) {
                $_SESSION['cart'][] = $id;
                $_SESSION['flash_success'] = 'Đã thêm "' . htmlspecialchars($product->name) . '" vào giỏ hàng!';
            } else {
                $_SESSION['flash_info'] = 'Sản phẩm này đã có trong giỏ hàng của bạn.';
            }
        } else {
            $_SESSION['flash_error'] = 'Sản phẩm này đã hết hàng hoặc không còn khả dụng.';
        }
        
        $referer = $_SERVER['HTTP_REFERER'] ?? (URLROOT . '/cart');
        header('location: ' . $referer);
        exit;
    }

    public function remove($id, $redirect = true) {
        if(($key = array_search($id, $_SESSION['cart'])) !== false) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            $_SESSION['flash_info'] = 'Đã xóa sản phẩm khỏi giỏ hàng.';
        }
        if($redirect) {
            header('location: ' . URLROOT . '/cart');
            exit;
        }
    }

    public function checkout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrfToken($_POST['csrf_token'] ?? '');
            
            if(!isset($_SESSION['user_id'])) {
                $_SESSION['flash_error'] = 'Vui lòng đăng nhập tài khoản để tiến hành đặt hàng.';
                header('location: ' . URLROOT . '/user/login');
                exit;
            }

            if(empty($_SESSION['cart'])) {
                $_SESSION['flash_error'] = 'Giỏ hàng của bạn đang trống.';
                header('location: ' . URLROOT . '/cart');
                exit;
            }

            $address = trim($_POST['shipping_address'] ?? '');
            if(empty($address)) {
                $_SESSION['flash_error'] = 'Vui lòng nhập địa chỉ giao hàng đầy đủ.';
                header('location: ' . URLROOT . '/cart');
                exit;
            }

            // Lấy lại danh sách sản phẩm từ DB
            $cart_items = [];
            $total = 0;
            foreach($_SESSION['cart'] as $id) {
                $product = $this->productModel->getProductById($id);
                if($product && $product->status == 'available') {
                    $cart_items[] = $product;
                    $total += $product->price;
                }
            }

            if(count($cart_items) == 0) {
                $_SESSION['flash_error'] = 'Rất tiếc, sản phẩm trong giỏ đã có người khác đặt mua.';
                $_SESSION['cart'] = [];
                header('location: ' . URLROOT . '/cart');
                exit;
            }

            if($this->orderModel->createOrder($_SESSION['user_id'], $total, $address, $cart_items)) {
                $_SESSION['cart'] = [];
                $_SESSION['flash_success'] = 'Đặt hàng thành công! Đơn hàng của bạn đang được xử lý.';
                header('location: ' . URLROOT . '/user/orders');
                exit;
            } else {
                $_SESSION['flash_error'] = 'Có lỗi xảy ra trong quá trình tạo đơn hàng. Vui lòng thử lại.';
                header('location: ' . URLROOT . '/cart');
                exit;
            }
        } else {
            header('location: ' . URLROOT . '/cart');
            exit;
        }
    }
}
