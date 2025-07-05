<?php
require_once '../../../config.php';
header('Content-Type: application/json');

// Ambil ID dari query string
$id = $_GET['id'] ?? 0;

// Validasi ID
if (!is_numeric($id) || $id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID tidak valid']);
    exit;
}

// Query data modul berdasarkan ID
$stmt = mysqli_prepare($conn, "SELECT id, nama_modul, id_praktikum, file_materi FROM modul WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Kirim data modul atau error
if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Data modul tidak ditemukan']);
    exit;
}
