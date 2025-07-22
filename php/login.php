<?php
// Menggunakan file koneksi.php untuk menghubungkan dengan database
include 'D:\laragon\www\uas_pemro\php\koneksi.php';

// Cek jika form login telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Melakukan query untuk memeriksa username dan password
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Login berhasil
        session_start();
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        // Login gagal
        echo "Username atau password salah!";
    }
}
?>

<?php
function add_css() {
    echo '<link rel="stylesheet" type="text/css" href="../css/styles.css">';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php add_css(); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h2 class="login-title">🔒 Login Admin</h2>
            <form action="login_process.php" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                
                <button type="submit" class="login-button">➡️ Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>
