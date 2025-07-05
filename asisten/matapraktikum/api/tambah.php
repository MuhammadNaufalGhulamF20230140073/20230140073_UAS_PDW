<?php
require_once '../../../config.php';

$nama = $_POST['nama_praktikum'] ?? '';
$deskripsi = $_POST['deskripsi'] ?? '';

if (empty($nama)) {
    die("Nama praktikum wajib diisi.");
}

$stmt = mysqli_prepare($conn, "INSERT INTO praktikum (nama_praktikum, deskripsi) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "ss", $nama, $deskripsi);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    header("Location: ../index.html");
    exit;
} else {
    echo "Gagal menambahkan praktikum: " . mysqli_error($conn);
}
