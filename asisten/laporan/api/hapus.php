<?php
require_once '../../../config.php';

$id = $_GET['id'] ?? 0;

if (!is_numeric($id) || $id <= 0) {
    die("ID tidak valid.");
}

// Ambil nama file untuk dihapus dari server
$query = mysqli_query($conn, "SELECT file_laporan FROM laporan WHERE id = $id");
$data = mysqli_fetch_assoc($query);
$file = $data['file_laporan'] ?? '';

if ($file && file_exists("../../../uploads/$file")) {
    unlink("../../../uploads/$file");
}

// Hapus laporan dari database
$stmt = mysqli_prepare($conn, "DELETE FROM laporan WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    header("Location: ../index.html");
    exit;
} else {
    echo "Gagal menghapus laporan: " . mysqli_error($conn);
}
