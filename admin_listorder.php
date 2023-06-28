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

    .select {
        width: 100%;
        border: none;
        outline: none;
        padding: 15px;
        background-color: #111111;
        color: white;
        font-family: ThanhHai;
    }
</style>
<?php
require_once './Class/Database.php';
require_once './Class/Orders.php';

$orders = new Orders();
$orderList = $orders->loadAllOrders();
$statusOptions = [
    'Đang chờ xác nhận',
    'Đơn hàng đang đóng gói',
    'Đơn hàng của bạn đang giao',
    'Giao hàng thành công',
    'Đơn hàng bị hủy'
];
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'save_') === 0) {
            $orderCode = substr($key, strlen('save_'));
            $status = $_POST['status_' . $orderCode];

            $orders->updateOrderStatus($orderCode, $status);
        }
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
            <h3>Danh sách đơn hàng</h3>

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
                    <form method="post">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Người mua</th>
                                    <th>Mã đơn hàng</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng giá</th>
                                    <th>Tùy chọn</th>
                                </tr>
                            </thead>
                            <tbody class="list_cart">
                                <?php foreach ($orderList as $order): ?>
                                    <tr>
                                        <td>
                                            <?php echo $order['fullname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $order['code_order']; ?>
                                        </td>
                                        <td>
                                            <?php echo $order['create_at']; ?>
                                        </td>
                                        <td>
                                            <select class="select" name="status_<?php echo $order['code_order']; ?>">
                                                <?php foreach ($statusOptions as $option): ?>
                                                    <option value="<?php echo $option; ?>" <?php if ($order['status'] == $option)
                                                           echo 'selected'; ?>>
                                                        <?php echo $option; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <?php echo number_format($order['total'], 0, ",", ".") . " VNĐ"; ?>
                                        </td>
                                        <td>
                                            <button type="submit" name="save_<?php echo $order['code_order']; ?>">Lưu đơn
                                                hàng</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>