<?php
require_once '../../../config.php';

$id = $_GET['id'] ?? 0;

if (!is_numeric($id) || $id <= 0) {
    die("ID tidak valid.");
}

$stmt = mysqli_prepare($conn, "DELETE FROM praktikum WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    header("Location: ../index.html");
    exit;
} else {
    echo "Gagal menghapus praktikum: " . mysqli_error($conn);
}
