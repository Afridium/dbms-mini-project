<?php
require 'config.php';
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php'); exit;
}

$search = $_GET['search'] ?? '';
$sql = "SELECT 
          student_id, 
          student_name, 
          student_phone, 
          object_id, 
          object_name, 
          description,
          lost_date, 
          last_seen
        FROM ticket_entries
        WHERE student_id LIKE ? OR object_name LIKE ? OR student_phone LIKE ?
        ORDER BY lost_date DESC";
$stmt = $pdo->prepare($sql);
$like = "%$search%";
$stmt->execute([$like,$like,$like]);
?>
<!doctype html>
<html>
<head><title>Admin Dashboard</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-danger">
  <div class="container-fluid">
    <span class="navbar-brand">Admin Panel</span>
    <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
  </div>
</nav>
<div class="container mt-4">
  <form class="mb-3 row g-2">
    <div class="col-md-4">
      <input class="form-control" type="search" name="search" placeholder="Search..." value="<?=htmlspecialchars($search)?>">
    </div>
    <div class="col">
      <button class="btn btn-primary">Search</button>
      <a href="admin_dashboard.php" class="btn btn-secondary">Reset</a>
    </div>
  </form>
  <table id="admintable" class="table table-striped">
    <thead>
  <tr>
    <th>Student ID</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Object</th>
    <th>Description</th>  <!-- New column -->
    <th>Lost Date</th>
    <th>Last Seen</th>
    <th>Action</th>
  </tr>
</thead>
    <tbody>
  <?php foreach ($stmt as $row): ?>
    <tr>
      <td><?= $row['student_id'] ?></td>
      <td><?= htmlspecialchars($row['student_name']) ?></td>
      <td><?= htmlspecialchars($row['student_phone']) ?></td>
      <td><?= htmlspecialchars($row['object_name']) ?></td>
      <td><?= htmlspecialchars($row['description']) ?></td>  <!-- New cell -->
      <td><?= $row['lost_date'] ?></td>
      <td><?= htmlspecialchars($row['last_seen']) ?></td>
      <td>
        <a class="btn btn-sm btn-warning" 
           href="mark_returned.php?id=<?= $row['object_id'] ?>" 
           onclick="return confirm('Mark as returned?')">
          Returned
        </a>
      </td>
    </tr>
  <?php endforeach; ?>
</tbody>
  </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(function() {
    $('#admintable').DataTable({ paging: true, searching: false });
});
</script>

</body>
</html>