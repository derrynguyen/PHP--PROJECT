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

    b {
        color: black;
    }
</style>
<?php
require_once './Class/Database.php';
require_once './Class/Orders.php';
$orders = new Orders();
$baohanhList = $orders->loadPhieuBaoHanh();
$statusOptions = [
    'Còn bảo hành',
    'Hết bảo hành',
];
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'save_') === 0) {
            $code_baohanh = str_replace('save_', '', $key); // Lấy mã bảo hành từ tên nút lưu
            $status = $_POST['status_' . $code_baohanh];

            $result = $orders->updateBaohanhStatus($code_baohanh, $status);

            if ($result) {
                header("Location: admin_baohanh.php");

                $error = "Cập nhật trạng thái bảo hành thành công.";
            } else {
                $error = "Lỗi khi cập nhật trạng thái bảo hành.";
            }
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
            <h3>Danh sách bảo hành</h3>

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
                    <form method="POST">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Mã bảo hành</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Người mua</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày hết hạn</th>
                                    <th>Trạng thái</th>
                                    <th>Tùy chọn</th>
                                </tr>
                            </thead>
                            <tbody class="list_cart">
                                <?php foreach ($baohanhList as $baohanh): ?>
                                    <tr>
                                        <td>
                                            <?php echo $baohanh['code_baohanh']; ?>
                                        </td>
                                        <td>
                                            <?php echo $baohanh['name_product']; ?>
                                        </td>
                                        <td>
                                            <?php echo $baohanh['fullname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $baohanh['create_at']; ?>
                                        </td>
                                        <td>
                                            <?php echo $baohanh['time_baohanh']; ?>
                                        </td>
                                        <td>
                                            <select class="select" name="status_<?php echo $baohanh['code_baohanh']; ?>">
                                                <?php foreach ($statusOptions as $option): ?>
                                                    <option value="<?php echo $option; ?>" <?php if ($baohanh['status'] == $option)
                                                           echo 'selected'; ?>>
                                                        <?php echo $option; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="submit" name="save_<?php echo $baohanh['code_baohanh']; ?>">Lưu
                                                lại</button>
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