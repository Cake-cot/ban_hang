<?php
class ProductController extends Controller {
    private $productModel;

    public function __construct() {
        $this->productModel = $this->model('Product');
    }

    public function index() {
        $this->search();
    }

    public function detail($slug = '') {
        $product = $this->productModel->getProductBySlug($slug);

        if (!$product) {
            $_SESSION['flash_error'] = 'Sản phẩm không tồn tại hoặc đã ngừng kinh doanh.';
            header('location: ' . URLROOT);
            exit;
        }

        $related = $this->productModel->getRelatedProducts($product->id, $product->category_id, 4);

        $data = [
            'title' => $product->name,
            'product' => $product,
            'related' => $related
        ];

        $this->view('layout/header', $data);
        $this->view('products/detail', $data);
        $this->view('layout/footer');
    }

    public function category($slug = '') {
        $category = null;
        $categories = $this->productModel->getCategories();
        foreach ($categories as $c) {
            if ($c->slug === $slug) {
                $category = $c;
                break;
            }
        }

        $products = $this->productModel->getProductsByCategory($slug);
        $brands = $this->productModel->getBrands();
        $sizes = $this->productModel->getAllSizes();

        $data = [
            'title' => $category ? $category->name : ('Giày ' . ucfirst($slug)),
            'category' => $category,
            'current_category' => $slug,
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'sizes' => $sizes
        ];

        $this->view('layout/header', $data);
        $this->view('products/category', $data);
        $this->view('layout/footer');
    }

    public function search() {
        $keyword = trim($_GET['q'] ?? '');
        $category_slug = trim($_GET['category'] ?? '');
        $brand_slug = trim($_GET['brand'] ?? '');
        $size = trim($_GET['size'] ?? '');
        $sort = trim($_GET['sort'] ?? 'newest');

        $products = $this->productModel->searchAndFilter($keyword, $category_slug, $brand_slug, $size, $sort);
        $categories = $this->productModel->getCategories();
        $brands = $this->productModel->getBrands();
        $sizes = $this->productModel->getAllSizes();

        $data = [
            'title' => !empty($keyword) ? ('Tìm kiếm: ' . $keyword) : 'Tất cả sản phẩm',
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'sizes' => $sizes,
            'keyword' => $keyword,
            'current_category' => $category_slug,
            'current_brand' => $brand_slug,
            'current_size' => $size,
            'current_sort' => $sort
        ];

        $this->view('layout/header', $data);
        $this->view('products/search', $data);
        $this->view('layout/footer');
    }
}
