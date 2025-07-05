<?php
require_once '../../../config.php';
session_start();

$id_praktikum = $_POST['id_praktikum'] ?? 0;
$id_mahasiswa = $_SESSION['user_id'] ?? 0;

if (!$id_mahasiswa || !$id_praktikum) {
    http_response_code(400);
    echo "Data tidak lengkap.";
    exit;
}

// Cegah duplikasi dengan INSERT IGNORE
$stmt = mysqli_prepare($conn, "INSERT IGNORE INTO praktikum_mahasiswa (id_praktikum, id_mahasiswa) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "ii", $id_praktikum, $id_mahasiswa);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    echo "Berhasil mendaftar ke praktikum.";
} else {
    echo "Gagal mendaftar: " . mysqli_error($conn);
}
