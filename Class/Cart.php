<?php

class Cart
{
    public $id_user;
    public $name_product;
    public $brand_id;

    public $price_product;
    public $imgur;
    public $amount_product;
    public $total;
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function addCartItem($id_user, $name_product, $brand_id, $price_product, $imgur, $amount_product, $total)
    {
        $stmt = $this->conn->prepare('INSERT INTO cart (id_user, name_product, brand_name, price_product, imgur, amount_product, total) VALUES (:id_user, :name_product, :brand_name, :price_product, :imgur, :amount_product, :total)');
        $stmt->bindValue(':id_user', $id_user);
        $stmt->bindValue(':name_product', $name_product);
        $stmt->bindValue(':brand_name', $brand_id);
        $stmt->bindValue(':price_product', $price_product);
        $stmt->bindValue(':imgur', $imgur);
        $stmt->bindValue(':amount_product', $amount_product);
        $stmt->bindValue(':total', $total);
        $stmt->execute();
    }

    public function loadCartItems($id_user)
    {
        $stmt = $this->conn->prepare('SELECT * FROM cart WHERE id_user = :id_user');
        $stmt->bindValue(':id_user', $id_user);
        $stmt->execute();
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $cartItems;
    }

    public function updateCartItemQuantityDB($item_id, $item_quantity, $id_user)
    {
        $query = "UPDATE cart SET amount_product = :quantity WHERE id = :item_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantity', $item_quantity);
        $stmt->bindParam(':item_id', $item_id);

        $stmt->execute();
    }

    public function getAllCartItems($id_user)
    {
        $stmt = $this->conn->prepare('SELECT * FROM cart WHERE id_user = :id_user');
        $stmt->bindValue(':id_user', $id_user);
        $stmt->execute();
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $cartItems;
    }
    public function saveOrderItems($id_user, $code_order)
    {
        $cartItems = $this->getAllCartItems($id_user);

        foreach ($cartItems as $item) {
            $code_baohanh = $this->generateRandomCodeBaoHanh();



            $brand_name = $item['brand_name'];
            $name_product = $item['name_product'];
            $price_product = $item['price_product'];
            $imgur = $item['imgur'];
            $amount_product = $item['amount_product'];
            $total = $item['price_product'] * $item['amount_product'];

            $stmt = $this->conn->prepare('INSERT INTO orders_item (id_user, code_order,code_baohanh,name_product, brand_name, price_product, imgur, amount_product, total) VALUES (:id_user, :code_order,:code_baohanh,:name_product, :brand_name, :price_product, :imgur, :amount_product, :total)');
            $stmt->bindValue(':id_user', $id_user);
            $stmt->bindValue(':code_order', $code_order);
            $stmt->bindValue(':code_baohanh', $code_baohanh);
            $stmt->bindValue(':name_product', $name_product);
            $stmt->bindValue(':brand_name', $brand_name);
            $stmt->bindValue(':price_product', $price_product);
            $stmt->bindValue(':imgur', $imgur);
            $stmt->bindValue(':amount_product', $amount_product);
            $stmt->bindValue(':total', $total);
            $stmt->execute();



            $status = 'Còn bảo hành';
            $create_at = date("d/m/Y");

            $nextYear = new DateTime();
            $nextYear->modify('+1 year');
            $time_baohanh = $nextYear->format('d/m/Y');

            $stmt = $this->conn->prepare('INSERT INTO phieubaohanh (code_baohanh, create_at,time_baohanh,status) VALUES (:code_baohanh, :create_at,:time_baohanh,:status)');
            $stmt->bindValue(':code_baohanh', $code_baohanh);
            $stmt->bindValue(':create_at', $create_at);
            $stmt->bindValue(':time_baohanh', $time_baohanh);
            $stmt->bindValue(':status', $status);
            $stmt->execute();


        }
    }
    public function clearCart($id_user)
    {
        $stmt = $this->conn->prepare('DELETE FROM cart WHERE id_user = :id_user');
        $stmt->bindValue(':id_user', $id_user);
        $stmt->execute();
    }

    public function generateRandomCode()
    {
        $code = mt_rand(11111, 99999);
        return 'GO' . $code;
    }
    public function generateRandomCodeBaoHanh()
    {
        $code = mt_rand(11111, 99999);
        return 'BH' . $code;
    }
    public function addOrder($id_user, $code_order, $create_at, $status, $total)
    {
        $stmt = $this->conn->prepare('INSERT INTO orders (id_user, code_order, create_at, status, total) VALUES (:id_user, :code_order, :create_at, :status, :total)');
        $stmt->bindValue(':id_user', $id_user);
        $stmt->bindValue(':code_order', $code_order);
        $stmt->bindValue(':create_at', $create_at);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':total', $total);
        $stmt->execute();
        header("Location: payment.php");

    }
    public function getTotalPrice($id_user)
    {
        $stmt = $this->conn->prepare('SELECT SUM(price_product * amount_product) as total_price FROM cart WHERE id_user = :id_user');
        $stmt->bindValue(':id_user', $id_user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalPrice = $result['total_price'];
        return $totalPrice;
    }


}
?>