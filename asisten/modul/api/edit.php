<?php
require_once '../../../config.php';

$id = $_POST['id'] ?? 0;
$nama_modul = trim($_POST['nama_modul'] ?? '');
$id_praktikum = $_POST['id_praktikum'] ?? 0;

// Validasi input
if (!is_numeric($id) || $id <= 0 || empty($nama_modul) || !is_numeric($id_praktikum) || $id_praktikum <= 0) {
    die("Data tidak lengkap atau tidak valid.");
}

// Cek apakah id_praktikum benar-benar ada di tabel praktikum
$cek = mysqli_query($conn, "SELECT COUNT(*) as total FROM praktikum WHERE id = $id_praktikum");
$cekData = mysqli_fetch_assoc($cek);
if ($cekData['total'] == 0) {
    die("ID praktikum tidak ditemukan di database.");
}

// Ambil data lama dari DB
$query = mysqli_query($conn, "SELECT file_materi FROM modul WHERE id = $id");
$dataLama = mysqli_fetch_assoc($query);
$file_materi = $dataLama['file_materi'] ?? '';

// Cek apakah ada file baru diupload
if (isset($_FILES['file_materi']) && $_FILES['file_materi']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../../../uploads/';
    $original = basename($_FILES['file_materi']['name']);
    $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
    $newName = uniqid('materi_') . '.' . $ext;
    $target = $uploadDir . $newName;

    // Pindahkan file ke folder uploads
    if (move_uploaded_file($_FILES['file_materi']['tmp_name'], $target)) {
        // Hapus file lama
        if (!empty($file_materi) && file_exists($uploadDir . $file_materi)) {
            unlink($uploadDir . $file_materi);
        }
        $file_materi = $newName;
    }
}

// Update data ke database
$stmt = mysqli_prepare($conn, "
    UPDATE modul 
    SET nama_modul = ?, id_praktikum = ?, file_materi = ?
    WHERE id = ?
");

mysqli_stmt_bind_param($stmt, "sisi", $nama_modul, $id_praktikum, $file_materi, $id);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    header("Location: ../index.html");
    exit;
} else {
    echo "Gagal update modul: " . mysqli_error($conn);
}
