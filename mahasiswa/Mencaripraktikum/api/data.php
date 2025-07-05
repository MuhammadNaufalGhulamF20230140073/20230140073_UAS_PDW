<?php
require_once '../../../config.php';
session_start();

$id_mahasiswa = $_SESSION['user_id'] ?? 0;

if (!$id_mahasiswa) {
    http_response_code(401);
    echo json_encode(['error' => 'Belum login']);
    exit;
}

$data = [];

$query = "SELECT 
            p.id, 
            p.nama_praktikum, 
            p.deskripsi,
            EXISTS (
                SELECT 1 FROM praktikum_mahasiswa pm
                WHERE pm.id_praktikum = p.id AND pm.id_mahasiswa = ?
            ) AS terdaftar
          FROM praktikum p";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_mahasiswa);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
