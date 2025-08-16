<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $sid = $_POST['student_id'];
    $pw  = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM website_users WHERE student_id=?");
    $stmt->execute([$sid]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pw, $user['password'])) {
        $_SESSION['user'] = $user;
        header('Location: user_dashboard.php'); exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!doctype html>
<html>
<head><title>Login</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:420px;">
  <h3 class="mb-3">Login</h3>
  <?php if (isset($_GET['registered'])) echo "<div class='alert alert-success'>Registered successfully. Please login.</div>"; ?>
  <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="post">
    <input class="form-control mb-2" name="student_id" placeholder="Student ID" required>
    <input type="password" class="form-control mb-2" name="password" placeholder="Password" required>
    <button class="btn btn-primary w-100">Login</button>
  </form>
  <a href="register.php" class="d-block mt-3 text-center">Create account</a>
</div>
</body>
</html>