<?php
session_start();
require_once '../../config.php';

// Pastikan user sudah login dan memiliki role Customer
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Customer') {
    header("Location: ../login.php");
    exit;
}

// Ambil data dari form
$customer_name = $_SESSION['username']; // otomatis ambil dari session
$profession = $_POST['profession'] ?? null;
$lawyer = $_POST['lawyer'] ?? null;
$day = $_POST['day'] ?? null;
$time = $_POST['time'] ?? null;
$date = date('Y-m-d'); // tanggal otomatis hari ini

// Validasi sederhana
if (!$profession || !$lawyer || !$day || !$time) {
    die("Semua kolom wajib diisi.");
}

try {
    // Simpan ke tabel consultation_schedule
    $stmt = $pdo->prepare("
        INSERT INTO consultation_schedule (customer_name, profession, lawyer_name, consultation_date, day, time)
        VALUES (:customer_name, :profession, :lawyer_name, :consultation_date, :day, :time)
    ");
    $stmt->execute([
        ':customer_name' => $customer_name,
        ':profession' => $profession,
        ':lawyer_name' => $lawyer,
        ':consultation_date' => $date,
        ':day' => $day,
        ':time' => $time
    ]);

    // Redirect kembali ke halaman jadwal
    header("Location: ../consultation/consultation.php?status=success");
    exit;
} catch (PDOException $e) {
    die("Gagal menyimpan data: " . $e->getMessage());
}
?>
