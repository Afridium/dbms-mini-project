<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $sid = trim($_POST['student_id']);
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone_number']);
    $pw  = $_POST['password'];
    $cpw = $_POST['confirm_password'];

    if ($pw !== $cpw) {
        $error = "Passwords do not match.";
    } elseif (strlen($pw) < 6) {
        $error = "Password must be ≥ 6 characters.";
    } else {
        $stmt = $pdo->prepare("SELECT 1 FROM website_users WHERE student_id=?");
        $stmt->execute([$sid]);
        if ($stmt->fetch()) {
            $error = "Student ID already exists.";
        } else {
            $hash = password_hash($pw, PASSWORD_DEFAULT);
            $pdo->prepare("INSERT INTO website_users VALUES (?,?,?,?)")
                ->execute([$sid,$name,$phone,$hash]);
            header('Location: login.php?registered=1'); exit;
        }
    }
}
?>
<!doctype html>
<html>
<head><title>Register</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:420px;">
  <h3 class="mb-3">Student Registration</h3>
  <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="post">
    <input class="form-control mb-2" name="student_id" placeholder="Student ID" required>
    <input class="form-control mb-2" name="name" placeholder="Full Name" required>
    <input class="form-control mb-2" name="phone_number" placeholder="Phone Number" required>
    <input type="password" class="form-control mb-2" name="password" placeholder="Password" required>
    <input type="password" class="form-control mb-2" name="confirm_password" placeholder="Confirm Password" required>
    <button class="btn btn-primary w-100">Register</button>
  </form>
  <a href="login.php" class="d-block mt-3 text-center">Already have an account? Login</a>
</div>
</body>
</html>