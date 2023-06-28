<?php
require_once "./Class/Database.php";
require_once "./Class/User.php";

$database = new Database();
$conn = $database->connect();
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $user = new User();
        if ($user->login($username, $password)) {
            header("Location: store.php");
            $error = "Đăng nhập thành công bằng tài khoản " . $username . "!";

            exit();
        } else {

            $error = "Đăng nhập thất bại. Vui lòng kiểm tra lại thông tin!";
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
        <div class="auth">
            <form method="POST" action="">
                <div class="login">
                    <h3>Đăng nhập tài khoản</h3>
                    <div class="input">
                        <label>Tài khoản</label>
                        <input type="text" name="username" placeholder="Nhập tài khoản của bạn">
                    </div>
                    <div class="input">
                        <label>Mật khẩu</label>
                        <input type="password" name="password" placeholder="Nhập mật khẩu của bạn">
                    </div>

                    <div class="button">
                        <button>Đăng nhập</button>
                    </div>
                    <div class="text">
                        <span>Bạn quên mật khẩu?

                            <a href="repassword.php">Lấy lại mật khẩu</a>
                        </span>
                    </div>
                    <div class="text">
                        <span>Nếu bạn chưa có tài khoản. Hãy bấm

                            <a href="resigter.php">Đăng ký ngay</a>
                        </span>
                    </div>
                </div>
            </form>

        </div>



        <!-- footer -->
        <?php include "Inc/footer.php" ?>
    </div>


</body>