<?php
require_once '../../../config.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? 0;

if (!is_numeric($id) || $id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID tidak valid']);
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT id, nama_praktikum, deskripsi FROM praktikum WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Data tidak ditemukan']);
}
