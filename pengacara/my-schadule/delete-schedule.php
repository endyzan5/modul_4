<?php
session_start();
require_once '../../config.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

// Ambil username dari sesi dan ID dari URL
$lawyer_username = $_SESSION['username'];
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

try {
    // Pastikan data yang akan dihapus memang milik lawyer yang sedang login
    $stmt = $pdo->prepare("DELETE FROM lawyer_schedule WHERE id = :id AND lawyer_username = :lawyer_username");
    $stmt->execute([
        'id' => $id,
        'lawyer_username' => $lawyer_username
    ]);

    // Redirect kembali ke halaman jadwal
    header("Location: my-schedule.php");
    exit;

} catch (PDOException $e) {
    die("Terjadi kesalahan: " . $e->getMessage());
}
?>
