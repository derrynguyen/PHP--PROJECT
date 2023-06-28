<style>
    .cart {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 5vh;
        background-color: white;
    }

    .container_cart {
        width: 100%;
        height: 100%;
        padding: 20px;
        border: none;
        background-color: white;
        color: black;


    }

    .table {
        background-color: white;

        text-align: center;
        width: 100%;
        color: black;
    }

    .table th,
    .table td {
        padding: 10px;
        color: black;
        background-color: white;
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

    .quantity {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity input {
        text-align: center;
        margin-top: 2vh;
        width: 10%;
        border: none;
        outline: none;
        padding: 15px;
        border-radius: 5px;
        background-color: #080808;
        color: white;
        font-family: ThanhHai;
    }

    .quantity button {
        margin-top: 2vh;
        width: 20%;
        border: none;
        outline: none;
        padding: 12px;
        background-color: black;
        color: white;
        font-family: ThanhHai;
        cursor: pointer;
        margin-left: 1vh;
    }

    .quantity button:hover {
        background-color: #ac0046;
        color: white;
    }

    .btn {
        position: absolute;
        width: 20%;
        text-align: center;
        bottom: 15vh;
    }

    .btn button {
        margin-top: 1vh;
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
</style>

<?php
require_once './Class/Database.php';
require_once './Class/Cart.php';
session_start();
$cart = new Cart();
$totalPrice = 0;

if (isset($_POST['payment'])) {
    $id_user = $_SESSION['login_detail']['id'];
    $code_order = $cart->generateRandomCode();
    $create_at = date('Y-m-d H:i:s');
    $status = "Đang chờ xác nhận";
    $total = $cart->getTotalPrice($id_user);

    $cart->saveOrderItems($id_user, $code_order);

    $cart->addOrder($id_user, $code_order, $create_at, $status, $total);

    $cart->clearCart($id_user);

}

?>

<body>
    <div class="container">
        <!-- Header -->
        <?php include "Inc/header.php" ?>

        <div class="cart">
            <div class="container_cart">
                <h3>Giỏ hàng của bạn</h3>
                <form method="post">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Thương hiệu</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng giá</th>
                            </tr>
                        </thead>
                        <tbody class="list_cart">
                            <?php
                            if (!isset($_SESSION['login_detail']['id'])) {
                                echo '<tr><td colspan="7">Ban vui lòng đăng nhập tài khoản.</td></tr>';
                            } else {
                                $id_user = $_SESSION['login_detail']['id'];


                                if (isset($_POST['btnupdate'])) {
                                    $item_ids = $_POST['item_id'];
                                    $item_quantities = $_POST['item_quantity'];

                                    for ($i = 0; $i < count($item_ids); $i++) {
                                        $item_id = $item_ids[$i];
                                        $item_quantity = $item_quantities[$i];
                                        $cart->updateCartItemQuantityDB($item_id, $item_quantity, $id_user);
                                    }
                                }

                                $cartItems = $cart->loadCartItems($id_user);

                                if ($cartItems) {
                                    foreach ($cartItems as $item) {
                                        echo '<tr>';
                                        echo '<td>' . $item['id'] . '</td>';
                                        echo '<td><img src="' . $item['imgur'] . '" alt="Product Image" /></td>';
                                        echo '<td>' . $item['name_product'] . '</td>';
                                        echo '<td>' . $item['brand_name'] . '</td>';
                                        echo '<td>' . number_format($item['price_product'], 0, ',', '.') . ' VNĐ</td>';
                                        echo '<td class="quantity">';
                                        echo '<input type="number" min="1" name="item_quantity[]" value="' . $item['amount_product'] . '" />';
                                        echo '<input type="hidden" name="item_id[]" value="' . $item['id'] . '" />';
                                        echo '<button name="btnupdate" type="submit">Cập nhật</button>';
                                        echo '</td>';
                                        echo '<td>' . number_format($item['price_product'] * $item['amount_product'], 0, ',', '.') . ' VNĐ</td>';
                                        echo '</tr>';

                                        $totalPrice += $item['price_product'] * $item['amount_product'];
                                    }
                                } else {
                                    echo '<tr><td colspan="7">Giỏ hàng của bạn trống.</td></tr>';
                                }
                            }
                            ?>
                        </tbody>

                    </table>
                    <div class="total">
                        <p>Tổng giá: <span>
                                <?php echo number_format($totalPrice, 0, ',', '.') . ' VNĐ'; ?>
                            </span></p>
                    </div>
                    <div class="btn">
                        <?php if ($cartItems): ?>
                            <button type="submit" name="payment">Thanh toán tất cả</button>
                        <?php else: ?>
                            <button type="button" style="opacity: 0.5;cursor: not-allowed;">Thanh toán tất
                                cả</button>
                        <?php endif; ?>
                    </div>

                </form>
            </div>
        </div>

        <!-- footer -->
        <?php include "Inc/footer.php" ?>
    </div>

</body>

</html>