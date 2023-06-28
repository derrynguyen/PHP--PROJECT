<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type='text/css' href="./Css/main.css">
    <link rel="stylesheet" href="./Css/phantrang.css">
    <link rel="stylesheet" href="./Css/notification.css">

    <title>PTTKTT - ĐỒ ÁN</title>
</head>
<style>
    .dropdown {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .dropdown-content {
        background-color: white;
        z-index: 1000;
        margin-left: -2vh;
        display: none;
        position: absolute;
        z-index: 1;
        top: 100%;
        left: 0;
        width: 20vh;
        padding: 20px;
        border-radius: 5px;
        color: black;
    }

    .dropdown:hover .dropdown-content {
        display: block;
        color: black;
    }

    .dropdown-content a {
        display: block;
        padding: 8px 0;
        text-decoration: none;
        color: black;
    }

    .dropdown-content a:hover {
        color: red;
    }
</style>
<?php session_start();
?>

<div class="header">
    <div class="navbar">
        <div class="left">
            <div class="nav">
                <a href="index.php">VINAGO</a>
            </div>
            <div class="nav">
                <a href="index.php">Trang chủ</a>
            </div>
            <div class="nav">
                <a href="store.php">Cửa hàng</a>
            </div>
            <!-- <div class="nav">
                <a href="about.php">Giới thiệu</a>
            </div> -->
        </div>
        <div class="right">
            <div class="nav" style="margin-left: 1vh;">
                <?php
                if (isset($_SESSION['login_detail'])) {
                    echo '<div class="dropdown">';
                    echo $_SESSION['login_detail']['fullname'];
                    echo '<div class="dropdown-content">
                            <a style="color: black;" href="profile.php">Thông tin tài khoản</a>
                            <a style="color: black;" href="cart.php">Giỏ hàng</a>
                            <a style="color: black;" href="payment.php">Thanh toán</a>';

                    if ($_SESSION['login_detail']['role'] == 2 || $_SESSION['login_detail']['role'] == 1) {
                        echo '<a style="color: black;" href="manager.php">Quản lý cửa hàng</a>';
                    }

                    echo '<a style="color: black;" href="logout.php">Đăng xuất</a>
                             </div>';
                    echo '</div>';
                } else {
                    echo '<a href="login.php">Đăng nhập</a>';
                }
                ?>
            </div>

        </div>

    </div>
</div>

</html>