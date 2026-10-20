<?php
class Order {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function createOrder($user_id, $total_amount, $shipping_address, $cart_items) {
        // Bắt đầu transaction
        // PDO transaction handling is tricky with custom wrapper if not exposed, 
        // but we can query directly or expose beginTransaction in Database class.
        // For simplicity, we'll run queries sequentially.
        
        $this->db->query("INSERT INTO orders (user_id, total_amount, shipping_address) VALUES (:user_id, :total, :address)");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':total', $total_amount);
        $this->db->bind(':address', $shipping_address);
        
        if ($this->db->execute()) {
            // Lấy order ID vừa tạo
            $this->db->query("SELECT LAST_INSERT_ID() as order_id");
            $order_id = $this->db->single()->order_id;

            // Thêm order items
            foreach ($cart_items as $item) {
                $this->db->query("INSERT INTO order_items (order_id, product_id, price) VALUES (:order_id, :product_id, :price)");
                $this->db->bind(':order_id', $order_id);
                $this->db->bind(':product_id', $item->id);
                $this->db->bind(':price', $item->price);
                $this->db->execute();

                // Cập nhật trạng thái sản phẩm thành đã bán
                $this->db->query("UPDATE products SET status = 'sold' WHERE id = :id");
                $this->db->bind(':id', $item->id);
                $this->db->execute();
            }
            return true;
        }
        return false;
    }

    public function getAdminOrders() {
        $this->db->query("SELECT o.*, u.username, u.email 
                          FROM orders o 
                          LEFT JOIN users u ON o.user_id = u.id 
                          ORDER BY o.created_at DESC");
        return $this->db->resultSet();
    }

    public function getUserOrders($user_id) {
        $this->db->query("SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC");
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function updateOrderStatus($order_id, $status) {
        $this->db->query("UPDATE orders SET status = :status WHERE id = :id");
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $order_id);
        return $this->db->execute();
    }

    public function getOrderById($order_id) {
        $this->db->query("SELECT o.*, u.username, u.email 
                          FROM orders o 
                          LEFT JOIN users u ON o.user_id = u.id 
                          WHERE o.id = :id");
        $this->db->bind(':id', $order_id);
        return $this->db->single();
    }

    public function getOrderItems($order_id) {
        $this->db->query("SELECT oi.*, p.name, p.slug, p.image_url, p.size, p.condition_status 
                          FROM order_items oi 
                          LEFT JOIN products p ON oi.product_id = p.id 
                          WHERE oi.order_id = :order_id");
        $this->db->bind(':order_id', $order_id);
        return $this->db->resultSet();
    }
}
