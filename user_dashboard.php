<?php
require 'config.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['student_id']==='admin') {
    header('Location: login.php'); exit;
}
$sid = $_SESSION['user']['student_id'];
?>
<!doctype html>
<html>
<head><title>Dashboard</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">Hello, <?=htmlspecialchars($_SESSION['user']['name'])?></span>
    <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
  </div>
</nav>
<div class="container mt-4">
  <div class="d-grid gap-2 col-md-6 mx-auto">
    <a class="btn btn-success btn-lg" href="create_ticket.php">Create Ticket</a>
    <a class="btn btn-secondary btn-lg" href="pending_tickets.php">Pending Tickets</a>
    <a class="btn btn-info btn-lg" href="history.php">Past History</a>
  </div>
</div>
</body>
</html>