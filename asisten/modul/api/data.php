<?php
require_once '../../../config.php';
header('Content-Type: application/json');

$result = mysqli_query($conn, "
  SELECT 
    m.id,
    m.nama_modul,
    m.file_materi,
    m.id_praktikum,
    p.nama_praktikum
  FROM modul m
  JOIN praktikum p ON m.id_praktikum = p.id
");

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => mysqli_error($conn)]);
    exit;
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
