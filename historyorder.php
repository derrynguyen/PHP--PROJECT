<style>
    .cart {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 5vh;
        background-color: white;
        color: black;
    }

    .container_cart {
        width: 100%;
        padding: 20px;
        color: black;
        border: none;
        background-color: white;
        height: 100%;
    }

    .table {
        text-align: center;
        width: 100%;
        color: black;
    }

    .table th,
    .table td {
        padding: 10px;
        color: black;
        border: 1px solid black;
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

    .btn {
        position: absolute;
        width: 20%;
        text-align: center;
        bottom: 15vh;
    }

    .btn button {
        margin-top: 3vh;
        width: 100%;
        border: none;
        outline: none;
        padding: 15px;
        border-radius: 5px;
        background-color: white;
        color: black;
        font-family: ThanhHai;
        cursor: pointer;
    }

    .btn button:hover {
        background-color: #ac0046;
        color: white;
    }

    .table .total {
        position: absolute;
    }

    .table .total p {
        font-size: 17px;
        color: gray;
    }

    .table .total p span {
        color: white;
        font-size: 23px;
    }

    a {
        color: black;
        text-decoration: none;
    }
</style>
<?php
require_once "./Class/Database.php";
require_once "./Class/User.php";
require_once "./Class/Product.php";
session_start();

$database = new Database();
$conn = $database->connect();
$product = new Product();

$user = new User();
$id_user = $_SESSION['login_detail']['id'];
$purchaseHistory = $product->loadPurchaseHistory($id_user);
?>

<body>
    <div class="container">
        <!-- Header -->
        <?php include "Inc/header.php" ?>

        <div class="cart">
            <div class="container_cart">
                <h3>Lịch sử mua hàng của bạn</h3>
                <form method="post">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mã bảo hành</th>
                                <th>Tên sản phẩm</th>
                                <th>Thương hiệu</th>
                                <th>Giá 1 cái</th>
                                <th>Số lượng</th>
                                <th>Tổng giá</th>
                            </tr>
                        </thead>
                        <tbody class="list_cart">
                            <?php if (!empty($purchaseHistory)): ?>
                                <?php foreach ($purchaseHistory as $item): ?>
                                    <tr>
                                        <td>
                                            <?= $item['code_baohanh'] ?>
                                        </td>
                                        <td>
                                            <?= $item['name_product'] ?>
                                        </td>
                                        <td>
                                            <?= $item['brand_name'] ?>
                                        </td>
                                        <td>
                                            <?= $item['price_product'] ?>
                                        </td>
                                        <td>
                                            <?= $item['amount_product'] ?>
                                        </td>
                                        <td>
                                            <?= $item['total'] ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">Lịch sử mua hàng trống.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>

        <!-- footer -->
        <?php include "Inc/footer.php" ?>
    </div>
</body>

</html>