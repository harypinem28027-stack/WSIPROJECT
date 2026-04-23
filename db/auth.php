<?php
class Auth {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login($usn_or_email, $password) {
        $usn_or_email = trim($usn_or_email);
        $password     = trim($password);

        // cek berdasarkan username ATAU email
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=? OR username=?");
        $stmt->bind_param("ss", $usn_or_email, $usn_or_email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user'] = $user;
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $user['username'];
                return true;
            }
        }

        return false;
    }
}
?>

