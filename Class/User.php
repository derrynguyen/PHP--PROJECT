<?php
class User
{
    public $id;
    public $username;
    public $password;
    public $fullname;
    public $birthday;
    public $phone;
    public $email;

    public $addreas;

    public $sex;

    public $role;
    public $is_online;
    public $is_banned;
    public $reason;


    public $conn; // Đối tượng kết nối cơ sở dữ liệu

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function register()
    {
        if ($this->kiemTraTenNguoiDung($this->username) && $this->kiemTraSoDienThoai($this->phone) && $this->kiemTraEmail($this->email)) {
            try {
                $sql = "INSERT INTO account (username, password, fullname, phone, email, addreas,  sex,birthday, role, is_online, is_banned, reason) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, 0, 0, '')";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $this->username);
                $passwordHash = md5($this->password);
                $stmt->bindParam(2, $passwordHash);
                $stmt->bindParam(3, $this->fullname);
                $stmt->bindParam(4, $this->phone);
                $stmt->bindParam(5, $this->email);
                $stmt->bindParam(6, $this->addreas);
                $stmt->bindParam(7, $this->sex);
                $stmt->bindParam(8, $this->birthday);


                if ($stmt->execute()) {
                    return true; // Đăng ký thành công
                } else {
                    return false; // Đăng ký thất bại
                }
            } catch (PDOException $e) {
                echo "Lỗi khi thực hiện truy vấn: " . $e->getMessage();
                return false; // Đăng ký thất bại
            }
        } else {
            return false; // Đăng ký thất bại
        }
    }


    private function kiemTraTenNguoiDung($username)
    {
        try {
            $sql = "SELECT * FROM account WHERE username = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $username);
            $stmt->execute();
            $result = $stmt->fetch();
            if ($result) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            echo "Lỗi khi thực hiện truy vấn: " . $e->getMessage();
        }
    }

    private function kiemTraSoDienThoai($phone)
    {
        try {
            $sql = "SELECT * FROM account WHERE phone = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $phone);
            $stmt->execute();
            $result = $stmt->fetch();
            if ($result) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            echo "Lỗi khi thực hiện truy vấn: " . $e->getMessage();
        }
    }

    private function kiemTraEmail($email)
    {
        try {
            $sql = "SELECT * FROM account WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $email);
            $stmt->execute();
            $result = $stmt->fetch();
            if ($result) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            echo "Lỗi khi thực hiện truy vấn: " . $e->getMessage();
        }
    }

    public function login($username, $password)
    {
        try {
            $sql = "SELECT * FROM account WHERE username = ? AND password = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $username);
            $passwordHash = md5($password);
            $stmt->bindParam(2, $passwordHash);
            $stmt->execute();
            $result = $stmt->fetch();

            if ($result) {
                if ($result['is_banned'] == 1) {
                    header("Location: banned.php");

                } else {
                    session_start();
                    $_SESSION['login_detail']['fullname'] = $result['fullname'];
                    $_SESSION['login_detail']['id'] = $result['id'];
                    $_SESSION['login_detail']['role'] = $result['role'];

                    // Update the is_online column to 1
                    $updateSql = "UPDATE account SET is_online = 1 WHERE id = ?";
                    $updateStmt = $this->conn->prepare($updateSql);
                    $updateStmt->bindParam(1, $result['id']);
                    $updateStmt->execute();

                    header("Location: store.php");
                    exit();
                }
            } else {
                echo "Tên người dùng hoặc mật khẩu không chính xác!";
            }
        } catch (PDOException $e) {
            echo "Lỗi khi thực hiện truy vấn: " . $e->getMessage();
        }
    }

    public function logout()
    {
        session_start();
        $userId = $_SESSION['login_detail']['id'];
        $updateSql = "UPDATE account SET is_online = 0 WHERE id = ?";
        $updateStmt = $this->conn->prepare($updateSql);
        $updateStmt->bindParam(1, $userId);
        $updateStmt->execute();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    public function loadDataProfile($id_user)
    {
        $stmt = $this->conn->prepare('SELECT * FROM account WHERE id = :id_user');
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        $profileData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$profileData) {
            return null;
        }

        $profile = new User();
        $profile->id = $profileData['id'];
        $profile->fullname = $profileData['fullname'];
        $profile->phone = $profileData['phone'];
        $profile->addreas = $profileData['addreas'];
        $profile->email = $profileData['email'];

        $profile->sex = $profileData['sex'];
        $profile->birthday = $profileData['birthday'];
        $profile->is_online = $profileData['is_online'];
        $profile->is_banned = $profileData['is_banned'];

        $profile->role = $profileData['role'];

        return $profile;
    }
    public function loadAllUsers()
    {
        try {
            $sql = "SELECT * FROM account";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            echo "Lỗi khi thực hiện truy vấn: " . $e->getMessage();
        }
    }

}