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
        padding: 10px;
        color: black;
        height: 100%;
        background-color: white;
        border: none;

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
        color: white;
        text-decoration: none;
    }
</style>
<?php
require_once 'Class/Database.php';
require_once 'Class/Orders.php';

if (isset($_GET['order_code'])) {
    $code_order = $_GET['order_code'];
    $orders = new Orders();
    $order = $orders->viewOrderDetails($code_order);
}
?>

<body>
    <div class="container">
        <!-- Header -->
        <?php include "Inc/header.php" ?>

        <div class="cart">
            <div class="container_cart">
                <h3>Đơn hàng:
                    <?php echo $code_order; ?>
                </h3>
                <form method="post">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Thương hiệu</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Mã bảo hành</th>


                            </tr>
                        </thead>
                        <tbody class="list_cart">
                            <?php
                            if ($order) {
                                foreach ($order['products'] as $product) {
                                    $image = $product['imgur'];
                                    $name = $product['name_product'];
                                    $brand = $product['brand_name'];
                                    $quantity = $product['amount_product'];
                                    $total_price = $product['total'];
                                    $code_baohanh = $product['code_baohanh'];

                                    echo "<tr>";
                                    echo "<td style='width: 10vh;'><img  src='$image' alt='$name'></td>";
                                    echo "<td>$name</td>";
                                    echo "<td>$brand</td>";
                                    echo "<td>$quantity</td>";
                                    echo "<td>$total_price</td>";
                                    echo "<td >$code_baohanh</td>";

                                    echo "</tr>";
                                }
                            }
                            ?>
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