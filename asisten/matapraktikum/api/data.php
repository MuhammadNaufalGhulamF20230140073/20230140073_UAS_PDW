<?php
require_once '../../../config.php'; // sesuaikan path jika beda
header('Content-Type: application/json');

// Ambil semua praktikum
$query = mysqli_query($conn, "SELECT * FROM praktikum ORDER BY id DESC");

$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode($data);
