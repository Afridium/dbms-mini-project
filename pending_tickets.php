<?php
require 'config.php';

/* ---- 1.  Auth check ---------------------------------------------------- */
if (!isset($_SESSION['user']) || $_SESSION['user']['student_id'] === 'admin') {
    header('Location: login.php');
    exit;
}
$sid = $_SESSION['user']['student_id'];

/* ---- 2.  DELETE ticket -------------------------------------------------- */
if (isset($_GET['del'])) {
    $pdo->prepare("DELETE FROM missing_objects WHERE id = ? AND student_id = ?")
        ->execute([$_GET['del'], $sid]);
    header('Location: pending_tickets.php');
    exit;
}

/* ---- 3.  UPDATE ticket -------------------------------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $pdo->prepare(
        "UPDATE missing_objects
         SET name = ?, description = ?, lost_date = ?, last_seen = ?
         WHERE id = ? AND student_id = ?"
    )->execute([
        $_POST['name'],
        $_POST['description'],
        $_POST['lost_date'],
        $_POST['last_seen'],
        $_POST['update_id'],
        $sid
    ]);
    header('Location: pending_tickets.php?updated=1');
    exit;
}

/* ---- 4.  Fetch pending tickets ----------------------------------------- */
$tickets = $pdo->prepare(
    "SELECT * FROM pending_tickets WHERE student_id = ? ORDER BY lost_date DESC"
);
$tickets->execute([$sid]);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Pending Tickets</title>
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <style>
  /* restore pointer events inside the modal */
  .modal,
  .modal * {
    pointer-events: auto !important;
  }
</style>
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">Pending Tickets</span>
    <a href="user_dashboard.php" class="btn btn-outline-light btn-sm">Back</a>
  </div>
</nav>

<div class="container mt-4">
  <?php if (isset($_GET['created'])): ?>
    <div class="alert alert-success">Ticket created.</div>
  <?php endif; ?>
  <?php if (isset($_GET['updated'])): ?>
    <div class="alert alert-success">Ticket updated.</div>
  <?php endif; ?>

  <table class="table table-bordered align-middle">
    <thead class="table-light">
      <tr>
        <th>Item</th>
        <th>Lost on</th>
        <th>Last seen</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($tickets as $t): ?>
      <tr>
        <td>
          <?= htmlspecialchars($t['name']) ?><br>
          <small><?= htmlspecialchars($t['description']) ?></small>
        </td>
        <td><?= $t['lost_date'] ?></td>
        <td><?= htmlspecialchars($t['last_seen']) ?></td>
        <td>
          <button class="btn btn-sm btn-warning"
                  data-bs-toggle="modal"
                  data-bs-target="#edit<?= $t['id'] ?>">
            Edit
          </button>
          <a class="btn btn-sm btn-danger"
             href="?del=<?= $t['id'] ?>"
             onclick="return confirm('Delete?')">
            Delete
          </a>
        </td>
      </tr>

      <!-- Edit Modal -->
      <div class="modal fade" id="edit<?= $t['id'] ?>" tabindex="-1">
        <div class="modal-dialog">
          <form method="post" action="pending_tickets.php" class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Ticket #<?= $t['id'] ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="update_id" value="<?= $t['id'] ?>">

              <label class="form-label">Object name</label>
              <input class="form-control mb-2" name="name"
                     value="<?= htmlspecialchars($t['name']) ?>" required>

              <label class="form-label">Description</label>
              <textarea class="form-control mb-2" name="description" rows="3" required><?=
                htmlspecialchars($t['description']) ?></textarea>

              <label class="form-label">Lost date</label>
              <input type="date" class="form-control mb-2" name="lost_date"
                     value="<?= $t['lost_date'] ?>" required>

              <label class="form-label">Last seen / Phone</label>
              <input class="form-control mb-2" name="last_seen"
                     value="<?= htmlspecialchars($t['last_seen']) ?>">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-success">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>