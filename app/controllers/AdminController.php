<?php
class AdminController extends Controller {
    private $productModel;
    private $orderModel;

    public function __construct() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header('location: ' . URLROOT);
            exit;
        }
        $this->productModel = $this->model('Product');
        $this->orderModel = $this->model('Order');
    }

    public function index() {
        $products = $this->productModel->getAllProductsAdmin();
        $orders = $this->orderModel->getAdminOrders();

        $total_products = count($products);
        $available_products = 0;
        $sold_products = 0;
        foreach($products as $p) {
            if ($p->status === 'available') {
                $available_products++;
            } else {
                $sold_products++;
            }
        }

        $total_orders = count($orders);
        $total_revenue = 0;
        $pending_orders = 0;
        foreach($orders as $o) {
            if ($o->status === 'completed' || $o->status === 'shipped') {
                $total_revenue += $o->total_amount;
            }
            if ($o->status === 'pending') {
                $pending_orders++;
            }
        }

        $data = [
            'title' => 'Admin Dashboard',
            'total_products' => $total_products,
            'available_products' => $available_products,
            'sold_products' => $sold_products,
            'total_orders' => $total_orders,
            'pending_orders' => $pending_orders,
            'total_revenue' => $total_revenue,
            'recent_orders' => array_slice($orders, 0, 5),
            'recent_products' => array_slice($products, 0, 5)
        ];

        $this->view('admin/layout/header', $data);
        $this->view('admin/dashboard', $data);
        $this->view('admin/layout/footer');
    }

    public function products() {
        $products = $this->productModel->getAllProductsAdmin();
        $data = [
            'title' => 'Quản lý Sản phẩm',
            'products' => $products
        ];
        $this->view('admin/layout/header', $data);
        $this->view('admin/products/index', $data);
        $this->view('admin/layout/footer');
    }

    public function create_product() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrfToken($_POST['csrf_token'] ?? '');
            
            $name = trim($_POST['name'] ?? '');
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name))) . '-' . time();
            
            $data = [
                'name' => $name,
                'slug' => $slug,
                'description' => trim($_POST['description'] ?? ''),
                'price' => floatval($_POST['price'] ?? 0),
                'size' => trim($_POST['size'] ?? ''),
                'condition_status' => trim($_POST['condition_status'] ?? ''),
                'brand_id' => intval($_POST['brand_id'] ?? 1),
                'category_id' => intval($_POST['category_id'] ?? 1),
                'image_url' => trim($_POST['image_url'] ?? ''),
                'status' => 'available'
            ];

            if ($this->productModel->addProduct($data)) {
                $_SESSION['flash_success'] = 'Thêm sản phẩm thành công!';
                header('location: ' . URLROOT . '/admin/products');
                exit;
            } else {
                $_SESSION['flash_error'] = 'Lỗi khi lưu sản phẩm vào cơ sở dữ liệu.';
                header('location: ' . URLROOT . '/admin/create_product');
                exit;
            }
        } else {
            $data = [
                'title' => 'Thêm Sản phẩm mới',
                'categories' => $this->productModel->getCategories(),
                'brands' => $this->productModel->getBrands(),
                'csrf_token' => $this->generateCsrfToken()
            ];
            $this->view('admin/layout/header', $data);
            $this->view('admin/products/create', $data);
            $this->view('admin/layout/footer');
        }
    }

    public function edit_product($id) {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            header('location: ' . URLROOT . '/admin/products');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrfToken($_POST['csrf_token'] ?? '');

            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'slug' => $product->slug,
                'description' => trim($_POST['description'] ?? ''),
                'price' => floatval($_POST['price'] ?? 0),
                'size' => trim($_POST['size'] ?? ''),
                'condition_status' => trim($_POST['condition_status'] ?? ''),
                'brand_id' => intval($_POST['brand_id'] ?? 1),
                'category_id' => intval($_POST['category_id'] ?? 1),
                'image_url' => trim($_POST['image_url'] ?? ''),
                'status' => in_array($_POST['status'] ?? '', ['available', 'sold']) ? $_POST['status'] : 'available'
            ];

            if ($this->productModel->updateProduct($id, $data)) {
                $_SESSION['flash_success'] = 'Cập nhật sản phẩm thành công!';
                header('location: ' . URLROOT . '/admin/products');
                exit;
            } else {
                $_SESSION['flash_error'] = 'Lỗi khi cập nhật sản phẩm.';
                header('location: ' . URLROOT . '/admin/edit_product/' . $id);
                exit;
            }
        } else {
            $data = [
                'title' => 'Chỉnh sửa Sản phẩm #' . $id,
                'product' => $product,
                'categories' => $this->productModel->getCategories(),
                'brands' => $this->productModel->getBrands(),
                'csrf_token' => $this->generateCsrfToken()
            ];
            $this->view('admin/layout/header', $data);
            $this->view('admin/products/edit', $data);
            $this->view('admin/layout/footer');
        }
    }

    public function delete_product($id) {
        if ($this->productModel->deleteProduct($id)) {
            $_SESSION['flash_success'] = 'Đã xóa sản phẩm thành công!';
        } else {
            $_SESSION['flash_error'] = 'Không thể xóa sản phẩm do đang có trong đơn hàng.';
        }
        header('location: ' . URLROOT . '/admin/products');
        exit;
    }

    public function update_status($id, $status) {
        if(in_array($status, ['available', 'sold'])) {
            $this->productModel->updateProductStatus($id, $status);
            $_SESSION['flash_success'] = 'Cập nhật trạng thái sản phẩm thành công!';
        }
        header('location: ' . URLROOT . '/admin/products');
        exit;
    }

    public function orders() {
        $orders = $this->orderModel->getAdminOrders();
        $data = [
            'title' => 'Quản lý Đơn hàng',
            'orders' => $orders
        ];
        $this->view('admin/layout/header', $data);
        $this->view('admin/orders/index', $data);
        $this->view('admin/layout/footer');
    }

    public function order_detail($id) {
        $order = $this->orderModel->getOrderById($id);
        if (!$order) {
            header('location: ' . URLROOT . '/admin/orders');
            exit;
        }

        $items = $this->orderModel->getOrderItems($id);

        $data = [
            'title' => 'Chi tiết Đơn hàng #' . $id,
            'order' => $order,
            'items' => $items
        ];

        $this->view('admin/layout/header', $data);
        $this->view('admin/orders/detail', $data);
        $this->view('admin/layout/footer');
    }

    public function update_order($id, $status) {
        $valid_statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        if(in_array($status, $valid_statuses)) {
            $this->orderModel->updateOrderStatus($id, $status);
            $_SESSION['flash_success'] = 'Cập nhật trạng thái đơn hàng #' . $id . ' thành công!';
        }
        header('location: ' . URLROOT . '/admin/orders');
        exit;
    }
}
