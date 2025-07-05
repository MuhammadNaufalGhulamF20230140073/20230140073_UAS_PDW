<?php
require_once '../../../config.php';
session_start();
header('Content-Type: application/json');

$id_praktikum = $_GET['id'] ?? 0;
$id_mahasiswa = $_SESSION['user_id'] ?? 0;

if (!$id_praktikum || !$id_mahasiswa) {
    http_response_code(400);
    echo json_encode(['error' => 'Data tidak lengkap']);
    exit;
}

// Ambil semua modul dari praktikum
$sql = "SELECT id, nama_modul, file_materi FROM modul WHERE id_praktikum = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_praktikum);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$modulList = [];
while ($modul = mysqli_fetch_assoc($result)) {
    $modul['sudah_upload'] = false;
    $modul['nilai'] = null;
    $modul['feedback'] = null;

    // Cek apakah mahasiswa sudah upload laporan untuk modul ini
    $stmt2 = mysqli_prepare($conn, "SELECT file_laporan, nilai, feedback FROM laporan WHERE id_modul = ? AND id_mahasiswa = ?");
    mysqli_stmt_bind_param($stmt2, "ii", $modul['id'], $id_mahasiswa);
    mysqli_stmt_execute($stmt2);
    $res2 = mysqli_stmt_get_result($stmt2);

    if ($laporan = mysqli_fetch_assoc($res2)) {
        $modul['sudah_upload'] = true;
        $modul['nilai'] = $laporan['nilai'];
        $modul['feedback'] = $laporan['feedback'];
    }

    $modulList[] = $modul;
}

echo json_encode($modulList);
