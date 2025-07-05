<?php
require_once '../../../config.php';

$id = $_POST['id'] ?? 0;
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? null;

// Validasi dasar
if (!is_numeric($id) || $id <= 0 || empty($nama) || empty($email)) {
    die("Data tidak lengkap atau tidak valid.");
}

// Ambil data lama (untuk password jika kosong)
$stmt = mysqli_prepare($conn, "SELECT password FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Pengguna tidak ditemukan.");
}

$passwordFinal = $row['password']; // default: password lama

if (!empty($password)) {
    $passwordFinal = password_hash($password, PASSWORD_DEFAULT);
}

// Update data
$stmt = mysqli_prepare($conn, "UPDATE users SET nama = ?, email = ?, password = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "sssi", $nama, $email, $passwordFinal, $id);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    header("Location: ../index.html");
    exit;
} else {
    echo "Gagal update akun: " . mysqli_error($conn);
}
