<?php
require_once '../../../config.php';

$nama_modul = $_POST['nama_modul'] ?? '';
$id_praktikum = $_POST['id_praktikum'] ?? 0;

if (empty($nama_modul) || $id_praktikum == 0 || !isset($_FILES['file_materi'])) {
    die("Data tidak lengkap.");
}

// Upload file
$uploadDir = '../../../uploads/';
$originalName = basename($_FILES["file_materi"]["name"]);
$extension = pathinfo($originalName, PATHINFO_EXTENSION);
$generatedName = uniqid('materi_') . '.' . $extension;
$targetFile = $uploadDir . $generatedName;

if (!move_uploaded_file($_FILES["file_materi"]["tmp_name"], $targetFile)) {
    die("Gagal upload file.");
}

// Simpan ke DB
$stmt = mysqli_prepare($conn, "INSERT INTO modul (id_praktikum, nama_modul, file_materi) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "iss", $id_praktikum, $nama_modul, $generatedName);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    header("Location: ../index.html");
    exit;
} else {
    echo "Gagal menambahkan modul: " . mysqli_error($conn);
}
