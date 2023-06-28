<?php

class Database
{
    private $servername = 'localhost';
    private $username = 'root';
    private $password = '123123';
    private $db = 'php';
    private $charset = 'utf8mb4';
    private $conn;

    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->servername . ';dbname=' . $this->db . ';charset=utf8mb4', $this->username, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // echo 'Kết nối thành công';
        } catch (PDOException $e) {
            // echo 'Kết nối thất bại: ' . $e->getMessage();
        }

        return $this->conn;
    }
}

?>