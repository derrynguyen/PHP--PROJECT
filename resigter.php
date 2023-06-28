<?php
require_once "./Class/Database.php";
require_once "./Class/User.php";

$database = new Database();
$conn = $database->connect();

$error = "";
$checked = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["fullname"]) && !empty($_POST["birthday"]) && !empty($_POST["sex"]) && isset($_POST["confirm"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $fullname = $_POST["fullname"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $addreas = $_POST["addreas"];
        $birthday = $_POST["birthday"];
        $sex = $_POST["sex"];

        $user = new User();
        $user->username = $username;
        $user->password = $password;
        $user->fullname = $fullname;
        $user->phone = $phone;
        $user->email = $email;
        $user->addreas = $addreas;
        $user->sex = $sex;
        $user->birthday = $birthday;

        if ($user->register()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Đăng ký thất bại. Vui lòng kiểm tra lại thông tin!";
        }
    } else {
        if (!isset($_POST["confirm"])) {
            $error = "Vui lòng xác nhận đã đọc và đồng ý với các yêu cầu của cửa hàng!";
        } else {
            $error = "Vui lòng điền đầy đủ thông tin!";
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
        <?php include "Inc/header.php" ?>
        <div class="body">
            <div class="auth">
                <form method="POST" action="">
                    <div class="login">
                        <h3>Đăng ký tài khoản</h3>

                        <div class="jcc">
                            <div class="left">
                                <div class="input">
                                    <label>Tài khoản</label>
                                    <input type="text" name="username" placeholder="Nhập tài khoản của bạn" required>
                                </div>
                                <div class="input">
                                    <label>Mật khẩu</label>
                                    <input type="password" name="password" placeholder="Nhập mật khẩu của bạn" required>
                                </div>
                                <div class="input">
                                    <label>Họ và tên</label>
                                    <input type="text" name="fullname" placeholder="Nhập họ và tên của bạn" required>
                                </div>
                                <div class="input">
                                    <label>Số điện thoại</label>
                                    <input type="text" name="phone" placeholder="Nhập số điện thoại của bạn">
                                </div>
                            </div>
                            <div class="right">
                                <div class="input">
                                    <label>Địa chỉ</label>
                                    <input type="text" name="addreas" placeholder="Nhập địa chỉ của bạn">
                                </div>
                                <div class="input">
                                    <label>Email</label>
                                    <input type="email" name="email" placeholder="Nhập email của bạn" required>
                                </div>
                                <div class="input">
                                    <label>Ngày sinh</label>
                                    <input type="date" name="birthday" placeholder="Nhập ngày sinh của bạn" required>
                                </div>
                                <div class="input">
                                    <label>Giới tính</label>
                                    <select class="select" name="sex" required>
                                        <option class="option" value="1">Nam</option>
                                        <option class="option" value="2">Nữ</option>
                                    </select>
                                </div>

                            </div>

                        </div>
                        <div class="input">
                            <label>Bạn đồng ý cung cấp thông tin cho chúng tôi thì hay tích vào ô bên dưới</label>
                            <input type="checkbox" name="confirm" <?php if ($checked)
                                echo "checked"; ?> required>
                        </div>
                        <div class="button">
                            <button type="submit">Đăng ký</button>
                        </div>

                        <div class="text">
                            <span>Nếu bạn đã có tài khoản. Hãy bấm <a href="login.php">Đăng nhập ngay</a></span>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <!-- footer -->
        <?php include "Inc/footer.php" ?>
    </div>
</body>