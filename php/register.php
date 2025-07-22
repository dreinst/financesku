<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div class="login-container">
      <div class="login-card">
          <h2 class="login-title">🔒 Login Admin</h2>
          <form action="../php/register_process.php" method="POST">
              <label for="username">Username</label>
              <input type="text" id="username" name="username" placeholder="Masukkan username" required>
              
              <label for="password">Password</label>
              <input type="password" id="password" name="password" placeholder="Masukkan password" required>
              
              <button type="submit" class="login-button">➡️ Daftar</button>
          </form>
      </div>
  </div>
</body>
</html>