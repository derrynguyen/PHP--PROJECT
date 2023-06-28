<?php
class Product
{
    public $id;
    public $name_product;
    public $price_product;
    public $brand_id;
    public $imgur;
    public $desc_product;
    public $conn;
    public $code_supplier;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function loadAll($offset = 0, $perPage = 6)
    {
        $stmt = $this->conn->prepare('SELECT * FROM product LIMIT :offset, :perPage');
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = array();

        foreach ($productData as $row) {
            $product = new Product();
            $product->id = $row['id'];
            $product->name_product = $row['name_product'];
            $product->price_product = $row['price_product'];
            $product->brand_id = $row['brand_id'];
            $product->imgur = $row['imgur'];
            $product->desc_product = $row['desc_product'];

            // Lấy tên brand từ bảng brand thông qua id
            $brandStmt = $this->conn->prepare('SELECT name_brand FROM brand WHERE id = :id');
            $brandStmt->bindValue(':id', $row['brand_id']);
            $brandStmt->execute();
            $brandData = $brandStmt->fetch(PDO::FETCH_ASSOC);

            if ($brandData) {
                $product->brand_id = $brandData['name_brand'];
            }

            $products[] = $product;
        }

        return $products;
    }


    public function getTotalCount()
    {
        $stmt = $this->conn->prepare('SELECT COUNT(*) FROM product');
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count;
    }

    public function getProductById($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM product WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $productData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($productData) {
            $product = new Product();
            $product->id = $productData['id'];
            $product->name_product = $productData['name_product'];
            $product->price_product = $productData['price_product'];
            $product->brand_id = $productData['brand_id'];
            $product->imgur = $productData['imgur'];
            $product->desc_product = $productData['desc_product'];

            // Lấy tên hãng từ bảng brand thông qua brand_id
            $brandStmt = $this->conn->prepare('SELECT name_brand FROM brand WHERE id = :brand_id');
            $brandStmt->bindValue(':brand_id', $productData['brand_id']);
            $brandStmt->execute();
            $brandData = $brandStmt->fetch(PDO::FETCH_ASSOC);

            if ($brandData) {
                $product->brand_id = $brandData['name_brand'];
            }

            return $product;
        } else {
            return null;
        }
    }
    public function searchProducts($keyword, $offset = 0, $perPage = 6)
    {
        $stmt = $this->conn->prepare('SELECT * FROM product WHERE name_product LIKE :keyword LIMIT :offset, :perPage');
        $stmt->bindValue(':keyword', '%' . $keyword . '%');
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = array();

        foreach ($productData as $row) {
            $product = new Product();
            $product->id = $row['id'];
            $product->name_product = $row['name_product'];
            $product->price_product = $row['price_product'];
            $product->brand_id = $row['brand_id'];
            $product->imgur = $row['imgur'];
            $product->desc_product = $row['desc_product'];

            // Lấy tên brand từ bảng brand thông qua id
            $brandStmt = $this->conn->prepare('SELECT name_brand FROM brand WHERE id = :id');
            $brandStmt->bindValue(':id', $row['brand_id']);
            $brandStmt->execute();
            $brandData = $brandStmt->fetch(PDO::FETCH_ASSOC);

            if ($brandData) {
                $product->brand_id = $brandData['name_brand'];
            }

            $products[] = $product;
        }

        return $products;
    }


    public function filterByPrice($order = 'asc', $offset = 0, $perPage = 6)
    {
        $stmt = $this->conn->prepare('SELECT * FROM product ORDER BY price_product ' . $order . ' LIMIT :offset, :perPage');
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = array();

        foreach ($productData as $row) {
            $product = new Product();
            $product->id = $row['id'];
            $product->name_product = $row['name_product'];
            $product->price_product = $row['price_product'];
            $product->brand_id = $row['brand_id'];
            $product->imgur = $row['imgur'];
            $product->desc_product = $row['desc_product'];

            // Lấy tên brand từ bảng brand thông qua id
            $brandStmt = $this->conn->prepare('SELECT name_brand FROM brand WHERE id = :id');
            $brandStmt->bindValue(':id', $row['brand_id']);
            $brandStmt->execute();
            $brandData = $brandStmt->fetch(PDO::FETCH_ASSOC);

            if ($brandData) {
                $product->brand_id = $brandData['name_brand'];
            }

            $products[] = $product;
        }

        return $products;
    }

    public function filterByBrand($brandId, $offset = 0, $perPage = 6)
    {
        $stmt = $this->conn->prepare('SELECT * FROM product WHERE brand_id = :brand_id LIMIT :offset, :perPage');
        $stmt->bindValue(':brand_id', $brandId);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = array();

        foreach ($productData as $row) {
            $product = new Product();
            $product->id = $row['id'];
            $product->name_product = $row['name_product'];
            $product->price_product = $row['price_product'];
            $product->brand_id = $row['brand_id'];
            $product->imgur = $row['imgur'];
            $product->desc_product = $row['desc_product'];

            // Lấy tên brand từ bảng brand thông qua id
            $brandStmt = $this->conn->prepare('SELECT name_brand FROM brand WHERE id = :id');
            $brandStmt->bindValue(':id', $row['brand_id']);
            $brandStmt->execute();
            $brandData = $brandStmt->fetch(PDO::FETCH_ASSOC);

            if ($brandData) {
                $product->brand_id = $brandData['name_brand'];
            }

            $products[] = $product;
        }

        return $products;
    }
    public function loadAllProducts()
    {
        try {
            $sql = "SELECT product.*, brand.name_brand, supplier.name_supplier 
                    FROM product
                    INNER JOIN brand ON product.brand_id = brand.id
                    INNER JOIN supplier ON product.code_supplier = supplier.id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            echo "Lỗi khi thực hiện truy vấn: " . $e->getMessage();
        }
    }



    public function addProduct($name_product, $brandId, $price, $description, $amount, $supplierId, $image)
    {
        try {
            $imgurUrl = $this->uploadToImgur($image);

            if ($imgurUrl) {
                $query = "INSERT INTO product (name_product, price_product, brand_id, imgur, desc_product, amount, code_supplier) 
                          VALUES (:name_product, :price, :brandId, :imgur, :description, :amount, :supplierId)";
                $statement = $this->conn->prepare($query);
                $statement->bindParam(':name_product', $name_product);
                $statement->bindParam(':price', $price);
                $statement->bindParam(':brandId', $brandId);
                $statement->bindParam(':imgur', $imgurUrl);
                $statement->bindParam(':description', $description);
                $statement->bindParam(':amount', $amount);
                $statement->bindParam(':supplierId', $supplierId);

                $statement->execute();

                return true;
            }

            return false;
        } catch (PDOException $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }


    private function uploadToImgur($imageFile)
    {
        $apiUrl = 'https://api.imgur.com/3/upload';
        $imagePath = $imageFile;
        $headers = array(
            'Authorization: Client-ID 02a10557c06322f'
        );

        $postData = array(
            'image' => new CURLFile($imagePath)
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);

        $response = curl_exec($curl);
        curl_close($curl);

        $responseData = json_decode($response, true);

        if (isset($responseData['success']) && $responseData['success']) {
            $imageUrl = $responseData['data']['link'];
            return $imageUrl;
        }

        return null;
    }





    public function getSuppliers()
    {
        try {
            $query = "SELECT * FROM supplier";
            $statement = $this->conn->prepare($query);
            $statement->execute();
            $suppliers = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $suppliers;
        } catch (PDOException $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return [];
        }
    }
    public function getBrands()
    {
        $query = "SELECT id, name_brand FROM brand";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        $brands = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $brands;
    }

    public function deleteProduct($productId)
    {
        try {
            $query = "DELETE FROM product WHERE id = :productId";
            $statement = $this->conn->prepare($query);
            $statement->bindParam(':productId', $productId);
            $statement->execute();

            return true;
        } catch (PDOException $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }
    public function findPhieuBaoHanhByID($code_baohanh, $userId)
    {
        $checkOwnershipQuery = "SELECT * FROM orders_item WHERE code_baohanh = :code_baohanh AND id_user = :userId";
        $ownershipStmt = $this->conn->prepare($checkOwnershipQuery);
        $ownershipStmt->bindParam(':code_baohanh', $code_baohanh);
        $ownershipStmt->bindParam(':userId', $userId);
        $ownershipStmt->execute();

        if ($ownershipStmt->rowCount() > 0) {
            $productInfoQuery = "SELECT oi.name_product, oi.brand_name, oi.amount_product, oi.total, pb.create_at, pb.time_baohanh, pb.status 
                             FROM orders_item AS oi 
                             INNER JOIN phieubaohanh AS pb ON oi.code_baohanh = pb.code_baohanh 
                             WHERE oi.code_baohanh = :code_baohanh";
            $productInfoStmt = $this->conn->prepare($productInfoQuery);
            $productInfoStmt->bindParam(':code_baohanh', $code_baohanh);
            $productInfoStmt->execute();

            if ($productInfoStmt->rowCount() > 0) {
                $productInfo = $productInfoStmt->fetch(PDO::FETCH_ASSOC);
                return $productInfo;
            } else {
                return "Không tìm thấy thông tin sản phẩm.";
            }
        } else {
            return "Mã này không thuộc về tài khoản của bạn.";
        }
    }


    public function loadPurchaseHistory($id_user)
    {
        global $conn;

        $query = "SELECT name_product, brand_name, price_product, amount_product, total, code_baohanh
                  FROM orders_item
                  WHERE id_user = :id_user";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
?>