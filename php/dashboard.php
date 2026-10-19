<?php
session_start();
include "db.php";

// Cek apakah sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil data akun & mahasiswa
$username = $_SESSION['username'];

$sql = "SELECT akun.*, mahasiswa.nama, mahasiswa.prodi, mahasiswa.angkatan, mahasiswa.alamat, mahasiswa.semester, mahasiswa.ipk 
        FROM akun 
        JOIN mahasiswa ON akun.nim = mahasiswa.nim
        WHERE akun.username = '$username'";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

// Tentukan warna background berdasarkan IPK
$ipk = floatval($data['ipk']);
if ($ipk >= 3.5) {
    $warna = "bg-success";
} elseif ($ipk >= 3.0 && $ipk < 3.5) {
    $warna = "bg-primary";
} elseif ($ipk < 3.0) {
    $warna = "bg-danger";
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Dashboard Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:600px;">
    <div class="card p-4 shadow">
        <h3 class="mb-3">Dashboard Mahasiswa</h3>
        <p>Selamat datang, <b><?= htmlspecialchars($username) ?></b>!</p>
        <table class="table">
            <tr><td>Nama</td><td><?= htmlspecialchars($data['nama']) ?></td></tr>
            <tr><td>NIM</td><td><?= htmlspecialchars($data['nim']) ?></td></tr>
            <tr><td>Alamat</td><td><?= htmlspecialchars($data['alamat']) ?></td></tr>
            <tr><td>Program Studi</td><td><?= htmlspecialchars($data['prodi']) ?></td></tr>
            <tr><td>Angkatan</td><td><?= htmlspecialchars($data['angkatan']) ?></td></tr>
            <tr><td>Semester</td><td><?= htmlspecialchars($data['semester']) ?></td></tr>
        </table>
        <div class="text-center mt-3">
          <strong>IPK:
          <span class="px-3 py-1 text-white rounded text-center <?= $warna ?>" style="display: inline">
            <?= htmlspecialchars($data['ipk']) ?>
          </span></strong>
        </div>
        <form method="POST" action="logout.php" class="mt-3">
            <button type="submit" class="btn btn-danger w-100">Logout</button>
        </form>
    </div>
</div>
</body>
</html>
