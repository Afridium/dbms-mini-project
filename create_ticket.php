<?php
require 'config.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['student_id']==='admin') {
    header('Location: login.php'); exit;
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $pdo->prepare("INSERT INTO missing_objects(name,description,lost_date,last_seen,phone_number,student_id)
                   VALUES (?,?,?,?,?,?)")
        ->execute([
            $_POST['name'],
            $_POST['description'],
            $_POST['lost_date'],
            $_POST['last_seen'],
            $_SESSION['user']['phone_number'],
            $_SESSION['user']['student_id']
        ]);
    header('Location: pending_tickets.php?created=1'); exit;
}
?>
<!doctype html>
<html>
<head><title>Create Ticket</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">Report Missing Item</span>
    <a href="user_dashboard.php" class="btn btn-outline-light btn-sm">Back</a>
  </div>
</nav>
<div class="container mt-4" style="max-width:600px;">
  <form method="post">
    <input class="form-control mb-2" name="name" placeholder="Item Name" required>
    <textarea class="form-control mb-2" name="description" placeholder="Description" rows="3" required></textarea>
    <input type="date" class="form-control mb-2" name="lost_date" required>
    <input class="form-control mb-2" name="last_seen" placeholder="Last seen location">
    <button class="btn btn-success">Submit Ticket</button>
  </form>
</div>
</body>
</html>