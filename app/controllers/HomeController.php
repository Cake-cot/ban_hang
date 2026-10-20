<?php
class HomeController extends Controller {
    private $productModel;

    public function __construct() {
        $this->productModel = $this->model('Product');
    }

    public function index() {
        $products = $this->productModel->getProducts();
        $categories = $this->productModel->getCategories();
        $brands = $this->productModel->getBrands();
        $sizes = $this->productModel->getAllSizes();
        
        $data = [
            'title' => 'Trang Chủ',
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'sizes' => $sizes
        ];

        $this->view('layout/header', $data);
        $this->view('home/index', $data);
        $this->view('layout/footer');
    }
}
