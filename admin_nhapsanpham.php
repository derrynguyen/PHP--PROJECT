<style>
    h4 {
        width: 100%;
        text-align: center;
        color: black;
    }

    label {
        color: white;
    }

    .form {
        background-color: gray;
        padding: 20px;
        margin-left: 30vh;
        width: 50vh;
    }

    button {
        margin-top: 3px;
        width: 100%;
        border: none;
        outline: none;
        padding: 10px;
        border-radius: 5px;
        background-color: black;
        color: white;
        font-family: ThanhHai;
        cursor: pointer;
    }

    button:hover {
        background-color: #ac0046;
        color: white;
    }

    a {
        color: black;
        text-decoration: none;
    }

    input {
        margin-top: 1vh;
        width: 100%;
        border: none;
        outline: none;
        padding: 15px;
        border-radius: 5px;
        background-color: #111111;
        color: white;
        font-family: ThanhHai;
    }


    .btn {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .btn button {
        margin-top: 3vh;
        width: 100%;
        border: none;
        outline: none;
        padding: 15px;
        border-radius: 5px;
        background-color: black;
        color: white;
        font-family: ThanhHai;
        cursor: pointer;
    }

    .btn button:hover {
        background-color: #ac0046;
        color: white;
    }

    .select {
        margin-top: 0.5vh;
        width: 100%;
        border: none;
        outline: none;
        padding: 15px;
        border-radius: 5px;
        background-color: #111111;
        color: white;
        font-family: ThanhHai;
    }
</style>
<?php
require_once './Class/Database.php';
require_once './Class/Product.php';
$product = new Product();
$suppliers = $product->getSuppliers();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name_product = $_POST["name_product"];
    $brandId = $_POST["brand_id"];
    $price = $_POST["price_product"];
    $description = $_POST["desc_product"];
    $amount = $_POST["amount"];
    $supplierId = $_POST["code_supplier"];
    $image = $_FILES["image"]["tmp_name"];

    $success = $product->addProduct($name_product, $brandId, $price, $description, $amount, $supplierId, $image);

    if ($success) {
        $error = "Thêm sản phẩm thành công.";
    } else {
        $error = "Lỗi khi thêm sản phẩm.";
    }
}


?>

<?php if (!empty($error)): ?>
    <div id="notification" class="notification" style="border-radius: 10px;">
        <?php echo $error; ?>
    </div>
    <script>
        setTimeout(function () {
            var notification = document.getElementById('notification');
            notification.style.display = 'none';
        }, 5000); // 5 seconds
    </script>
<?php endif; ?>

<body>
    <div class="container">
        <!-- Header -->
        <?php include "Inc/header.php"; ?>
        <div class="manager">
            <h3>Nhập sản phẩm</h3>

            <div class="manager_main">
                <div class="left">
                    <div class="navbar">
                        <?php if ($_SESSION['login_detail']['role'] == 2): ?>
                            <div class="nav">
                                <a href="manager.php">Tài khoản người dùng</a>
                            </div>
                            <div class="nav">
                                <a href="admin_listproduct.php">Danh sách sản phẩm</a>
                            </div>
                            <div class="nav">
                                <a href="admin_listorder.php">Kiểm duyệt đơn hàng</a>
                            </div>
                            <div class="nav">
                                <a href="admin_baohanh.php">Bảo hành sản phẩm</a>
                            </div>
                            <div class="nav">
                                <a href="admin_nhapsanpham.php">Nhập sản phẩm</a>
                            </div>
                        <?php elseif ($_SESSION['login_detail']['role'] == 1): ?>
                            <div class="nav">
                                <a href="admin_listorder.php">Kiểm duyệt đơn hàng</a>
                            </div>
                            <div class="nav">
                                <a href="admin_baohanh.php">Bảo hành sản phẩm</a>
                            </div>
                        <?php else: ?>
                            <div class="notification">Bạn không có quyền truy cập!</div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="right_manager">
                    <form method="post" class="form" enctype="multipart/form-data">
                        <div class="input">
                            <input type="text" name="name_product" placeholder="Nhập tên sản phẩm" required>
                        </div>
                        <div class="input">
                            <select class="select" name="brand_id" required>
                                <option value="">Chọn nhãn hiệu</option>
                                <?php
                                $brands = $product->getBrands();
                                foreach ($brands as $brand) {
                                    echo '<option value="' . $brand['id'] . '">' . $brand['name_brand'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input">
                            <input type="number" name="price_product" placeholder="Nhập giá sản phẩm" required>
                        </div>
                        <div class="input">
                            <input type="text" name="desc_product" placeholder="Nhập mô tả sản phẩm">
                        </div>
                        <div class="input">
                            <input type="text" name="amount" placeholder="Nhập số lượng">
                        </div>
                        <div class="input">
                            <select class="select" name="code_supplier" required>
                                <option value="">Chọn đơn vị cung cấp</option>
                                <?php
                                foreach ($suppliers as $supplier) {
                                    echo '<option value="' . $supplier['id'] . '">' . $supplier['name_supplier'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="input">
                            <input type="file" name="image" accept="image/*">
                        </div>
                        <div class="btn">
                            <button type="submit">Nhập sản phẩm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>