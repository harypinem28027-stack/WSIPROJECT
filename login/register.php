<?php
require_once '../config.php';
require_once '../db/auth.php';

$db = new Database();
$conn = $db->getConnection();
$auth = new Auth($conn);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $sandi = trim($_POST['sandi']);

    // Validation
    if (empty($nama) || empty($email) || empty($sandi)) {
        $error = '❌ Semua field harus diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = '❌ Email tidak valid.';
    } elseif (strlen($sandi) < 6) {
        $error = '❌ Password minimal 6 karakter.';
    } else {
        // Check if exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
        $stmt->bind_param("ss", $nama, $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = '❌ Username atau email sudah terdaftar.';
        } else {
            // Hash pw
            $hashed_pw = password_hash($sandi, PASSWORD_DEFAULT);
            
            // Insert
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nama, $email, $hashed_pw);
            
            if ($stmt->execute()) {
                $success = '✅ Registrasi berhasil! Silakan login.';
                // Optional: auto login
                // $auth->login($nama, $sandi);
                // header('Location: login.php');
            } else {
                $error = '❌ Gagal registrasi. Coba lagi.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register account</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
</head>
<body>
<div class="main-wrapper">
    <header class="form-header">
        <h1>SELAMAT DATANG</h1>
        <p>REGISTER AKUN ANDA.</p>
    </header>

    <div class="form-container">
        <form action="" method="post" class="user-form">
            <div class="input-group">
                <label for="nama">Username</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan username Anda" value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email Anda" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            </div>
            
            <div class="input-group">
                <label for="sandi">Password</label>
                <input type="password" id="sandi" name="sandi" placeholder="Masukkan password Anda (min 6 char)" required>
            </div>

            <button type="submit" class="submit-button">Daftar</button>
            <?php if ($error): ?>
            <div style="margin-top: 10px; color: red;"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
            <div style="margin-top: 10px; color: green;"><?php echo $success; ?></div>
            <?php endif; ?>
            <div class="register-link">
                <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
