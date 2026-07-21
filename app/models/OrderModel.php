<?php

class OrderModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // -- For Customer --

    public function createOrder($user_id, $total_amount, $cart_items)
    {
        // Begin Transaction natively using PDO
        $this->db->query("START TRANSACTION");
        $this->db->execute();

        try {
            // 1. Insert Order
            $this->db->query('INSERT INTO orders (user_id, total_amount, status) VALUES (:user_id, :total_amount, :status)');
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':total_amount', $total_amount);
            $this->db->bind(':status', 'pending');
            $this->db->execute();
            
            $order_id = $this->db->lastInsertId();

            // 2. Insert Order Items
            foreach($cart_items as $item) {
                $this->db->query('INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (:order_id, :book_id, :qty, :price)');
                $this->db->bind(':order_id', $order_id);
                $this->db->bind(':book_id', $item['id']);
                $this->db->bind(':qty', $item['qty']);
                $this->db->bind(':price', $item['price']);
                $this->db->execute();
            }

            // Commit
            $this->db->query("COMMIT");
            $this->db->execute();

            return $order_id;
        } catch (Exception $e) {
            $this->db->query("ROLLBACK");
            $this->db->execute();
            return false;
        }
    }

    public function getOrdersByUserId($user_id)
    {
        $this->db->query('SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function getOrderById($id)
    {
        // Get order + user email
        $this->db->query('SELECT orders.*, users.name as user_name, users.email FROM orders JOIN users ON orders.user_id = users.id WHERE orders.id = :id');
        $this->db->bind(':id', $id);
        $order = $this->db->single();

        if($order) {
            $this->db->query('SELECT order_items.*, books.title, books.image FROM order_items JOIN books ON order_items.book_id = books.id WHERE order_id = :order_id');
            $this->db->bind(':order_id', $id);
            $order['items'] = $this->db->resultSet();
        }

        return $order;
    }

    public function uploadReceipt($order_id, $receipt_path)
    {
        $this->db->query('UPDATE orders SET payment_receipt = :receipt, status = :status WHERE id = :id');
        $this->db->bind(':receipt', $receipt_path);
        $this->db->bind(':status', 'paid');
        $this->db->bind(':id', $order_id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // -- For Admin --
    
    public function getAllOrders()
    {
        $this->db->query('SELECT orders.*, users.name as user_name FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC');
        return $this->db->resultSet();
    }

    public function updateOrderStatus($id, $status)
    {
        $this->db->query('UPDATE orders SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
