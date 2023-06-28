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
</style>
<?php
require_once './Class/Database.php';
require_once './Class/User.php';

$user = new User();

$users = $user->loadAllUsers();

?>

<body>
    <div class="container">
        <!-- Header -->
        <?php include "Inc/header.php"; ?>
        <div class="manager">
            <h3>Danh sách người dùng</h3>

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
                    <div class="box1" id="box1">
                        <form method="post">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Họ và tên</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ</th>
                                        <th>Giới tính</th>
                                        <th>Ngày sinh</th>
                                        <th>Trạng thái</th>
                                        <th>Tình trạng tài khoản</th>

                                        <th>Loại tài khoản</th>
                                        <th>Tùy chọn</th>

                                    </tr>
                                </thead>
                                <tbody class="list_cart">

                                    <?php foreach ($users as $user): ?>

                                        <tr>
                                            <td>
                                                <?php echo $user['fullname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $user['email']; ?>
                                            </td>
                                            <td style="width:13vh">
                                                <?php
                                                $phone = $user['phone'];
                                                $formattedPhone = substr_replace($phone, ' ', 4, 0);
                                                $formattedPhone = substr_replace($formattedPhone, ' ', 8, 0);

                                                echo $formattedPhone;
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo $user['addreas']; ?>
                                            </td>
                                            <td>
                                                <?php echo ($user['sex'] == 1) ? 'Nam' : 'Nữ'; ?>
                                            </td>
                                            <td>
                                                <?php echo $user['birthday']; ?>
                                            </td>
                                            <td>
                                                <?php echo ($user['is_online'] == 1) ? 'Online' : 'Offline'; ?>
                                            </td>
                                            <td>
                                                <?php echo ($user['is_banned'] == 1) ? 'Bị khóa' : 'Bình thường'; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $role = '';
                                                switch ($user['role']) {
                                                    case 0:
                                                        $role = 'Khách hàng';
                                                        break;
                                                    case 1:
                                                        $role = 'Nhân viên';
                                                        break;
                                                    case 2:
                                                        $role = 'Quản lý';
                                                        break;
                                                }
                                                echo $role;
                                                ?>
                                            </td>
                                            <td>
                                                <button type="submit" name="payment">Khóa tài khoản</button>
                                                <button type="submit" name="payment">Chỉnh sửa</button>

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
    </div>

</body>