<?php
require_once '../../../config.php';

$id = $_POST['id'] ?? 0;
$nilai = $_POST['nilai'] ?? null;
$feedback = $_POST['feedback'] ?? '';

if (!is_numeric($id) || $id <= 0 || !is_numeric($nilai)) {
    die("Data tidak valid.");
}

$stmt = mysqli_prepare($conn, "UPDATE laporan SET nilai = ?, feedback = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "isi", $nilai, $feedback, $id);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    header("Location: ../index.html");
    exit;
} else {
    echo "Gagal menyimpan nilai: " . mysqli_error($conn);
}
