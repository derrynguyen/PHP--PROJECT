<style>
    .box {
        width: 100%;
        height: 100%;
        padding-bottom: 5vh;
        margin-top: 20vh;
    }

    .box p {
        color: gray;
        font-size: 17px;
    }

    .box p span {
        margin-left: 1vh;
        color: black;
        font-size: 20px;
    }

    .table {
        padding: 20px;
        text-align: center;
        width: 100%;
        color: white;
    }

    .table th,
    .table td {
        padding: 10px;
        color: black;
    }

    .table th {
        background-color: #333;
        color: white;
        font-weight: bold;
        border: 1px soild black;
    }

    .box_find {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .box_find input {
        margin-top: 1vh;
        width: 80%;
        border: none;
        outline: none;
        padding: 15px;
        border-radius: 5px;
        background-color: #080808;
        color: white;
        font-family: ThanhHai;
    }

    .box_find button {
        margin-top: 1vh;
        width: 80%;
        border: none;
        outline: none;
        padding: 15px;
        border-radius: 5px;
        background-color: black;
        color: white;
        font-family: ThanhHai;
        cursor: pointer;
    }

    .box_find button:hover {
        background-color: #ac0046;
        color: white;
    }
</style>
<?php
require_once './Class/Database.php';
require_once './Class/User.php';
require_once './Class/Product.php';

session_start();
$user = new User();
$product = new Product();
$error = "";

$id_user = $_SESSION['login_detail']['id'];
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
        <?php include "Inc/header.php" ?>
        <div class="baohanh">
            <div class="baohanh_main">
                <div class="left">
                    <div class="box">
                        <h3>Bảo hành của bạn</h3>
                        <form action="" method="POST" class="box_find">
                            <input type="text" name="code_baohanh" placeholder="Nhập mã số bảo hành của sản phẩm" />
                            <button type="submit" name="search">Tìm kiếm</button>
                        </form>
                        <hr />
                        <div class="table">
                            <?php
                            if (isset($_POST['search'])) {
                                $code_baohanh = $_POST['code_baohanh'];
                                $productInfo = $product->findPhieuBaoHanhByID($code_baohanh, $id_user);

                                if (is_array($productInfo)) {
                                    echo "<table>";
                                    echo "<tr><th>Tên sản phẩm</th><th>Thương hiệu</th><th>Số lượng</th><th>Tổng giá</th><th>Ngày tạo</th><th>Thời gian bảo hành</th><th>Trạng thái</th></tr>";
                                    echo "<tr>";
                                    echo "<td>" . $productInfo['name_product'] . "</td>";
                                    echo "<td>" . $productInfo['brand_name'] . "</td>";
                                    echo "<td>" . $productInfo['amount_product'] . "</td>";
                                    echo "<td>" . $productInfo['total'] . "</td>";
                                    echo "<td>" . $productInfo['create_at'] . "</td>";
                                    echo "<td>" . $productInfo['time_baohanh'] . "</td>";
                                    echo "<td>" . $productInfo['status'] . "</td>";
                                    echo "</tr>";
                                    echo "</table>";
                                } else {
                                    echo $productInfo;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <?php include "Inc/footer.php" ?>
    </div>
</body>