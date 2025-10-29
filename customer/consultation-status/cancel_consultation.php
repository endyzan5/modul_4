<?php
session_start();
require_once '../../config.php';

// Cek apakah login sebagai Customer
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Customer') {
    header("Location: ../login.php");
    exit;
}

// Hanya proses POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $consultationId = $_POST['consultation_id'] ?? null;

    if ($consultationId) {
        // Update status jadi Cancelled hanya jika masih Pending
        $stmt = $pdo->prepare("
            UPDATE consultation_schedule 
            SET status = 'Cancelled' 
            WHERE id = :id AND status = 'Pending'
        ");
        $stmt->execute(['id' => $consultationId]);

        // Cek apakah ada baris yang berubah
        if ($stmt->rowCount() > 0) {
            $message = "Konsultasi berhasil dibatalkan.";
        } else {
            $message = "Konsultasi tidak dapat dibatalkan (mungkin sudah Accepted atau dibatalkan sebelumnya).";
        }
    } else {
        $message = "ID konsultasi tidak valid.";
    }

    // Redirect kembali ke halaman utama dengan pesan sukses
    header("Location: consultation-status.php?success=" . urlencode($message));
    exit;
} else {
    header("Location: consultation-status.php");
    exit;
}
?>
