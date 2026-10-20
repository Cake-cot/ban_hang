<?php
class Product {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getProducts() {
        $this->db->query("SELECT p.*, b.name as brand_name, c.name as category_name 
                          FROM products p 
                          LEFT JOIN brands b ON p.brand_id = b.id
                          LEFT JOIN categories c ON p.category_id = c.id
                          WHERE p.status = 'available'
                          ORDER BY p.created_at DESC");
        return $this->db->resultSet();
    }
    
    // Cho Admin: Lấy tất cả (cả đã bán)
    public function getAllProductsAdmin() {
        $this->db->query("SELECT p.*, b.name as brand_name, c.name as category_name 
                          FROM products p 
                          LEFT JOIN brands b ON p.brand_id = b.id
                          LEFT JOIN categories c ON p.category_id = c.id
                          ORDER BY p.created_at DESC");
        return $this->db->resultSet();
    }

    public function getProductsByCategory($slug) {
        $this->db->query("SELECT p.*, b.name as brand_name, c.name as category_name 
                          FROM products p 
                          LEFT JOIN brands b ON p.brand_id = b.id
                          LEFT JOIN categories c ON p.category_id = c.id
                          WHERE p.status = 'available' AND c.slug = :slug
                          ORDER BY p.created_at DESC");
        $this->db->bind(':slug', $slug);
        return $this->db->resultSet();
    }

    public function getProductBySlug($slug) {
        $this->db->query("SELECT p.*, b.name as brand_name, c.name as category_name 
                          FROM products p 
                          LEFT JOIN brands b ON p.brand_id = b.id
                          LEFT JOIN categories c ON p.category_id = c.id
                          WHERE p.slug = :slug");
        $this->db->bind(':slug', $slug);
        return $this->db->single();
    }

    public function getProductById($id) {
        $this->db->query("SELECT * FROM products WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getCategories() {
        $this->db->query("SELECT * FROM categories");
        return $this->db->resultSet();
    }

    public function getBrands() {
        $this->db->query("SELECT * FROM brands");
        return $this->db->resultSet();
    }

    public function addProduct($data) {
        $this->db->query("INSERT INTO products (name, slug, description, price, size, condition_status, brand_id, category_id, image_url, status) 
                          VALUES (:name, :slug, :description, :price, :size, :condition_status, :brand_id, :category_id, :image_url, :status)");
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':slug', $data['slug']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':size', $data['size']);
        $this->db->bind(':condition_status', $data['condition_status']);
        $this->db->bind(':brand_id', $data['brand_id']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':image_url', $data['image_url']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }
    
    public function updateProductStatus($id, $status) {
        $this->db->query("UPDATE products SET status = :status WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        return $this->db->execute();
    }

    public function updateProduct($id, $data) {
        $this->db->query("UPDATE products SET 
                          name = :name, 
                          slug = :slug, 
                          description = :description, 
                          price = :price, 
                          size = :size, 
                          condition_status = :condition_status, 
                          brand_id = :brand_id, 
                          category_id = :category_id, 
                          image_url = :image_url, 
                          status = :status 
                          WHERE id = :id");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':slug', $data['slug']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':size', $data['size']);
        $this->db->bind(':condition_status', $data['condition_status']);
        $this->db->bind(':brand_id', $data['brand_id']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':image_url', $data['image_url']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function deleteProduct($id) {
        $this->db->query("DELETE FROM products WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getRelatedProducts($productId, $categoryId, $limit = 4) {
        $this->db->query("SELECT p.*, b.name as brand_name, c.name as category_name 
                          FROM products p 
                          LEFT JOIN brands b ON p.brand_id = b.id
                          LEFT JOIN categories c ON p.category_id = c.id
                          WHERE p.id != :id AND p.status = 'available' AND p.category_id = :category_id
                          ORDER BY p.created_at DESC LIMIT :limit");
        $this->db->bind(':id', $productId);
        $this->db->bind(':category_id', $categoryId);
        $this->db->bind(':limit', (int)$limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function searchAndFilter($keyword = '', $category_slug = '', $brand_slug = '', $size = '', $sort = 'newest') {
        $sql = "SELECT p.*, b.name as brand_name, b.slug as brand_slug, c.name as category_name, c.slug as category_slug 
                FROM products p 
                LEFT JOIN brands b ON p.brand_id = b.id
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.status = 'available' ";
        
        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND (p.name LIKE :kw OR p.description LIKE :kw OR b.name LIKE :kw) ";
            $params[':kw'] = '%' . $keyword . '%';
        }

        if (!empty($category_slug)) {
            $sql .= " AND c.slug = :cat_slug ";
            $params[':cat_slug'] = $category_slug;
        }

        if (!empty($brand_slug)) {
            $sql .= " AND b.slug = :brand_slug ";
            $params[':brand_slug'] = $brand_slug;
        }

        if (!empty($size)) {
            $sql .= " AND p.size = :size ";
            $params[':size'] = $size;
        }

        switch($sort) {
            case 'price_asc':
                $sql .= " ORDER BY p.price ASC ";
                break;
            case 'price_desc':
                $sql .= " ORDER BY p.price DESC ";
                break;
            case 'name_asc':
                $sql .= " ORDER BY p.name ASC ";
                break;
            case 'newest':
            default:
                $sql .= " ORDER BY p.created_at DESC ";
                break;
        }

        $this->db->query($sql);
        foreach($params as $key => $val) {
            $this->db->bind($key, $val);
        }
        return $this->db->resultSet();
    }

    public function getAllSizes() {
        $this->db->query("SELECT DISTINCT size FROM products WHERE size IS NOT NULL AND size != '' ORDER BY size ASC");
        return $this->db->resultSet();
    }
}
