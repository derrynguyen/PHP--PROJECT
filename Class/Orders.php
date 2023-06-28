<?php
class Orders
{
    public $id;
    public $id_user;
    public $code_order;
    public $create_at;
    public $status;
    public $total;
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function loadOrdersByUserId($id_user)
    {
        $stmt = $this->conn->prepare('SELECT * FROM orders WHERE id_user = :id_user');
        $stmt->bindValue(':id_user', $id_user);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    }

    public function viewOrderDetails($code_order)
    {
        $stmt = $this->conn->prepare('SELECT * FROM orders WHERE code_order = :code_order');
        $stmt->bindValue(':code_order', $code_order);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            $stmt = $this->conn->prepare('SELECT * FROM orders_item WHERE code_order = :code_order');
            $stmt->bindValue(':code_order', $code_order);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $order['products'] = $products;
        }

        return $order;
    }
    public function loadAllOrders()
    {
        $stmt = $this->conn->prepare('SELECT o.*, a.fullname FROM orders o JOIN account a ON o.id_user = a.id');
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    }
    public function updateOrderStatus($orderCode, $status)
    {
        $stmt = $this->conn->prepare('UPDATE orders SET status = :status WHERE code_order = :orderCode');
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':orderCode', $orderCode);
        $stmt->execute();
        header("Location: admin_listorder.php");

    }
    public function loadPhieuBaoHanh()
    {
        $sql = "SELECT pb.code_baohanh, pb.create_at, pb.time_baohanh, pb.status, oi.name_product, a.fullname
                FROM phieubaohanh pb
                INNER JOIN orders_item oi ON pb.code_baohanh = oi.code_baohanh
                INNER JOIN account a ON oi.id_user = a.id
                GROUP BY pb.code_baohanh";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $baohanhList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $baohanhList;

    }



    public function updateBaohanhStatus($code_baohanh, $status)
    {
        try {
            $sql = "UPDATE phieubaohanh SET status = :status WHERE code_baohanh = :code_baohanh";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':code_baohanh', $code_baohanh);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Lỗi khi cập nhật trạng thái bảo hành: " . $e->getMessage());
            return false;
        }
    }




}