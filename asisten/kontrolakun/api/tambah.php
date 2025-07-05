<?php
require_once '../../../config.php';

$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if (empty($nama) || empty($email) || empty($password) || !in_array($role, ['asisten', 'mahasiswa'])) {
    die("Data tidak lengkap atau tidak valid.");
}

// Cek apakah email sudah digunakan
$cek = mysqli_query($conn, "SELECT id FROM users WHERE email = '" . mysqli_real_escape_string($conn, $email) . "'");
if (mysqli_num_rows($cek) > 0) {
    die("Email sudah terdaftar.");
}

// Simpan ke DB
$hashed = password_hash($password, PASSWORD_DEFAULT);
$stmt = mysqli_prepare($conn, "INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $nama, $email, $hashed, $role);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    header("Location: ../index.html");
    exit;
} else {
    echo "Gagal menambahkan akun: " . mysqli_error($conn);
}
