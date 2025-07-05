<?php
require_once '../../../config.php';
header('Content-Type: application/json');

// Ambil semua user dari database
$query = mysqli_query($conn, "SELECT id, nama, email, role FROM users ORDER BY created_at DESC");

$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

// Kembalikan data dalam format JSON
echo json_encode($data);
