<?php
require 'config.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['student_id']==='admin') {
    header('Location: login.php'); exit;
}
$sid = $_SESSION['user']['student_id'];
// New query (with JOIN):
$rows = $pdo->prepare(
    "SELECT h.*, u.name AS student_name 
     FROM history h
     JOIN website_users u ON h.student_id = u.student_id
     WHERE h.student_id = ? 
     ORDER BY h.returned_date DESC"
);
$rows->execute([$sid]);
?>
<!doctype html>
<html>
<head><title>History</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">Resolved Tickets</span>
    <a href="user_dashboard.php" class="btn btn-outline-light btn-sm">Back</a>
  </div>
</nav>
<div class="container mt-4">
<table class="table table-bordered">
  <thead class="table-light">
    <tr><th>Object</th><th>Lost on</th><th>Returned on</th></tr>
  </thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?=htmlspecialchars($r['object_name'])?></td>
      <td><?=$r['lost_date']?></td>
      <td><?=$r['returned_date']?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
</body>
</html>