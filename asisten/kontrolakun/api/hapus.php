<?php
require_once '../../../config.php';

$id = $_GET['id'] ?? 0;

if (!is_numeric($id) || $id <= 0) {
    die("ID tidak valid.");
}

// Eksekusi hapus
$stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    header("Location: ../index.html");
    exit;
} else {
    echo "Gagal menghapus akun: " . mysqli_error($conn);
}
