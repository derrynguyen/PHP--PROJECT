<style>
    h4 {
        width: 100%;
        text-align: center;
        color: black;
    }

    .table {
        text-align: center;
        color: black;
        width: 100%;
        height: 80%;

    }

    .table th,
    .table td {
        padding: 10px;
        border: 0.1px solid black;
        color: black;
    }

    .table th {
        background-color: #333;
        color: white;
        font-weight: bold;
    }

    .table img {
        width: 100px;
        height: auto;
        display: block;
        margin: 0 auto;
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

    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }

    .popup-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
    }
</style>

<?php
require_once './Class/Database.php';
require_once './Class/Product.php';
$product = new Product();

$error = "";

$products = $product->loadAllProducts();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['productID']) && isset($_POST['productName']) && $_POST['productName'] === 'deleteProductButton') {
    $productId = $_POST["productID"];
    echo "<script>console.log('ID sản phẩm:', " . $productId . ");</script>";

    $success = $product->deleteProduct($productId);

    if ($success) {
        $error = "Xóa sản phẩm thành công.";
    } else {
        $error = "Xóa sản phẩm không thành công.";
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
            <h3>Danh sách sản phẩm</h3>

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
                    <form method="post" id="deleteForm">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Hãng</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tùy chọn</th>
                                </tr>
                            </thead>
                            <tbody class="list_cart">
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo $product['imgur']; ?>" />
                                        </td>
                                        <td>
                                            <?php echo $product['name_product']; ?>
                                        </td>
                                        <td>
                                            <?php echo $product['name_brand']; ?>
                                        </td>
                                        <td>
                                            <?php echo $product['name_supplier']; ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($product['price_product'], 0, ",", ".") . " VNĐ"; ?>
                                        </td>
                                        <td>
                                            <?php echo $product['amount']; ?>
                                        </td>
                                        <td>
                                            <button type="button"
                                                onclick="openPopup(<?php echo $product['id']; ?>)">Xóa</button>
                                            <button type="button" name="payment">Chỉnh sửa</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <input type="hidden" name="productID" id="productID">
                        <input type="hidden" name="productName" id="productName">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openPopup(productID) {
            var popup = document.getElementById("popup-" + productID);
            popup.style.display = "block";
        }

        function closePopup(productID) {
            var popup = document.getElementById("popup-" + productID);
            popup.style.display = "none";
        }

        // Sử dụng event delegation để bắt sự kiện click trên nút Xóa
        document.addEventListener("click", function (event) {
            if (event.target.name === "deleteProductButton") {
                var productID = event.target.dataset.productId;
                deleteProduct(productID);
            }
        });

        function deleteProduct(productID) {
            var popup = document.getElementById("popup-" + productID);
            var confirmButton = popup.querySelector("[name='deleteProductButton']");

            // Xử lý sự kiện khi nút Xóa trong popup được nhấn
            confirmButton.addEventListener("click", function () {
                var form = document.getElementById("deleteForm");
                var productIDInput = document.getElementById("productID");
                productIDInput.value = productID;
                form.submit();
            });

            closePopup(productID);
        }
    </script>
</body>