<?php
require_once '../../../config.php';

$id = $_POST['id'] ?? 0;
$nama = $_POST['nama_praktikum'] ?? '';
$deskripsi = $_POST['deskripsi'] ?? '';

if (!is_numeric($id) || $id <= 0 || empty($nama)) {
    die("Data tidak valid.");
}

$stmt = mysqli_prepare($conn, "UPDATE praktikum SET nama_praktikum = ?, deskripsi = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "ssi", $nama, $deskripsi, $id);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    header("Location: ../index.html");
    exit;
} else {
    echo "Gagal update praktikum: " . mysqli_error($conn);
}
