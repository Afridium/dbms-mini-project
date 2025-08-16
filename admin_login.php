<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $user = $_POST['username'];
    $pw   = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username=?");
    $stmt->execute([$user]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && $pw === $admin['password']) {
        $_SESSION['admin'] = $admin['username'];
        header('Location: admin_dashboard.php'); exit;
    } else {
        $error = "Invalid admin credentials.";
    }
}
?>
<!doctype html>
<html>
<head><title>Admin Login</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:380px;">
  <h3 class="mb-3 text-center">Admin Login</h3>
  <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="post">
    <input class="form-control mb-2" name="username" placeholder="Username" required>
    <input type="password" class="form-control mb-3" name="password" placeholder="Password" required>
    <button class="btn btn-dark w-100">Login</button>
  </form>
  <a href="login.php" class="d-block mt-3 text-center">Student Login</a>
</div>
</body>
</html>