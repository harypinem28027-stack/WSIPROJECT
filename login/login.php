<?php
require_once '../config.php';
require_once '../db/Auth.php';

$db = new Database();
$conn = $db->getConnection();
$auth = new Auth($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input dari form
    $usn_or_email = trim($_POST['username_or_email']);
    $password     = trim($_POST['password']);

    // Cek login (Auth.php sudah cek email OR username)
    if ($auth->login($usn_or_email, $password)) {
        header('Location: ../admin/app.php');
        exit;
    } else {
        $error = "❌ Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Log-in account</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
</head>
<body>

<div class="main-wrapper">
    <header class="form-header">
        <h1>SELAMAT DATANG</h1>
        <p>Silakan isi Name, Email, dan password dengan benar.</p>
    </header>

    <div class="form-container">
        <form action="" method="post" class="user-form">

<div class="input-group">
                <label for="username_or_email">Username atau Email</label>
                <input type="text" id="username_or_email" name="username_or_email" placeholder="Masukkan username atau email Anda" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
            </div>

            <div class="register-link">
                <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
            </div>

            <button type="submit" class="submit-button">Masuk</button>
            <?php if (isset($error) && $error): ?>
                <div style="margin-top: 10px; color: red;"><?php echo $error; ?></div>
            <?php endif; ?>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
        crossorigin="anonymous"></script>

</body>
</html>
