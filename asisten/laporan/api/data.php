<?php
require_once '../../../config.php';
header('Content-Type: application/json');

// Ambil data laporan dengan JOIN ke modul & users (mahasiswa)
$query = mysqli_query($conn, "
    SELECT 
        laporan.id,
        laporan.file_laporan,
        laporan.nilai,
        modul.nama_modul,
        users.nama AS nama_mahasiswa
    FROM laporan
    JOIN modul ON laporan.id_modul = modul.id
    JOIN users ON laporan.id_mahasiswa = users.id
    ORDER BY laporan.id DESC
");

$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode($data);
