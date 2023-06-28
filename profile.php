<style>
    .box {
        margin-top: 15vh;
        width: 100%;
        height: 100%;
        padding-bottom: 5vh;

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
        color: black;
    }

    .table th,
    .table td {
        padding: 10px;
        color: black;

    }

    .table th {
        background-color: #333;
        color: black;
        font-weight: bold;
    }

    .btn {
        margin-top: 3vh;
        width: 100%;
        text-align: center;
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .btn button {
        margin-top: -1vh;
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
</style>
<?php
require_once './Class/Database.php';
require_once './Class/User.php';
session_start();
$user = new User();
$id_user = $_SESSION['login_detail']['id'];

?>

<body>
    <div class="container">
        <!-- Header -->
        <?php include "Inc/header.php" ?>
        <div class="profile">
            <div class="profile_main">
                <div class="left">
                    <div class="box">
                        <h3>Thông tin của bạn</h3>
                        <?php
                        $profile = $user->loadDataProfile($id_user);

                        if (!$profile) {
                            echo "Không tìm thấy thông tin profile.";
                            return;
                        }
                        $phone = $profile->phone;
                        $formattedPhone = substr_replace($phone, ' ', 4, 0);
                        $formattedPhone = substr_replace($formattedPhone, ' ', 8, 0);
                        // Hiển thị thông tin profile
                        echo "<p>Họ và tên: <span>" . $profile->fullname . "</span></p>";
                        echo "<p>Địa chỉ:<span> " . $profile->addreas . "</span></p>";
                        echo "<p>Số điện thoại: <span>" . $formattedPhone . "</span></p>";
                        echo "<p>Email: <span>" . $profile->email . "</span></p>";
                        if ($profile->sex == 1) {
                            echo "<p>Giới tính: <span>Nam</span></p>";
                        } else {
                            echo "<p>Giới tính: <span>Nữ</span></p>";
                        }
                        echo "<p>Ngày sinh: <span>" . $profile->birthday . "</span></p>";
                        if ($profile->role == 0) {
                            echo "<p>Loại tài khoản: <span>Khách hàng</span></p>";
                        } elseif ($profile->role == 1) {
                            echo "<p>Loại tài khoản: <span>Nhân viên</span></p>";
                        } else {
                            echo "<p>Loại tài khoản: <span style='color:red'>Quản lý</span></p>";
                        }


                        ?>
                        <hr />
                        <div class="btn">
                            <button type="submit" name="payment">Chỉnh sửa thông tin</button>
                        </div>
                        <div class="btn">
                            <button type="submit" name="payment">
                                <a style="color:white;text-decoration: none;" href="baohanh.php">Tra cứu bảo hành sản
                                    phẩm</a>
                            </button>
                        </div>
                        <div class="btn">
                            <button type="submit" name="payment">
                                <a style="color:white;text-decoration: none; " href=" historyorder.php">Lịch sử mua
                                    hàng</a>
                            </button>
                        </div>
                        <hr />

                    </div>

                </div>


            </div>
        </div>


        <!-- footer -->
        <?php include "Inc/footer.php" ?>
    </div>


</body>