<?php
session_start();
require_once '../../config.php';

// Cek login dan role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: ../login.php");
    exit;
}

// Pastikan parameter ID dikirim
if (isset($_GET['id'])) {
    $lawyer_id = $_GET['id'];

    // Ambil user_id dari tabel lawyers
    $stmt = $pdo->prepare("SELECT user_id FROM lawyers WHERE id = ?");
    $stmt->execute([$lawyer_id]);
    $lawyer = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lawyer) {
        $user_id = $lawyer['user_id'];

        // Hapus data dari tabel users (lawyers otomatis terhapus karena ON DELETE CASCADE)
        $stmt_delete_user = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt_delete_user->execute([$user_id]);

        // Redirect kembali ke halaman data
        header("Location: lwyer-data.php");
        exit;
    } else {
        echo "Lawyer tidak ditemukan.";
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
