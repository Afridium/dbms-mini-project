<?php
require 'config.php';
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php'); exit;
}
$id = $_GET['id'] ?? 0;
// Get row
$stmt = $pdo->prepare("SELECT * FROM missing_objects WHERE id=?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row) {
    // Archive
    $pdo->prepare("INSERT INTO history (student_id,object_name,lost_date)
                   VALUES (?,?,?)")
         ->execute([$row['student_id'], $row['name'], $row['lost_date']]);
    // Delete
    $pdo->prepare("DELETE FROM missing_objects WHERE id=?")->execute([$id]);
}
header('Location: admin_dashboard.php');
?>