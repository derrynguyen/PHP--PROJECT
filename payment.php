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

<body>
    <div class="container">
        <!-- Header -->
        <?php include "Inc/header.php" ?>

        <div class="cart">
            <div class="container_cart">
                <h3>Đơn hàng của bạn</h3>
                <form method="post">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày tạo</th>
                                <th>Trạng thái</th>
                                <th>Tổng tiền</th>
                                <th>Tùy chỉnh</th>

                            </tr>
                        </thead>
                        <tbody class="list_cart">
                            <?php
                            require_once './Class/Database.php';
                            require_once './Class/Orders.php';
                            $orders = new Orders();
                            $user_id = $_SESSION['login_detail']['id'];
                            $order_list = $orders->loadOrdersByUserId($user_id);

                            foreach ($order_list as $order) {
                                $order_code = $order['code_order'];
                                $create_date = $order['create_at'];
                                $status = $order['status'];
                                $total_price = $order['total'];

                                // Tạo dòng trong bảng HTML với thông tin từng đơn hàng
                                echo "<tr>";
                                echo "<td>$order_code</td>";
                                echo "<td>$create_date</td>";
                                echo "<td>$status</td>";
                                echo "<td>" . number_format($total_price, 0, ",", ".") . " VNĐ</td>";
                                echo "<td><a href='orderdetail.php?order_code=$order_code'>Xem chi tiết</a></td>";

                                echo "</tr>";
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