<?php
require_once '../../../config.php';

$id = $_GET['id'] ?? 0;

if ($id > 0) {
    $stmt = mysqli_prepare($conn, "DELETE FROM modul WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

header("Location: ../index.html");
exit;
