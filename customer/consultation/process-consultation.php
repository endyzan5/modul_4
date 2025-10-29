<?php
session_start();
require_once '../../config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Customer') {
    header("Location: ../login.php");
    exit;
}

$customer_name = $_SESSION['username'];
$profession = $_POST['profession'] ?? null;
$lawyer = $_POST['lawyer'] ?? null;
$lawyer_id = $_POST['lawyer_id'] ?? null;
$day = $_POST['day'] ?? null;
$time = $_POST['time'] ?? null;
$date = date('Y-m-d');

// Validasi sederhana
if (!$profession || !$lawyer || !$lawyer_id || !$day || !$time) {
    die("Semua kolom wajib diisi.");
}

try {
    // Ambil customer_id dari tabel users
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$customer_name]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$customer) {
        die("Customer tidak ditemukan.");
    }

    $customer_id = $customer['id'];

    // Simpan data konsultasi
    $stmt = $pdo->prepare("
        INSERT INTO consultation_schedule 
        (lawyer_id, customer_id, customer_name, profession, lawyer_name, consultation_date, day, time)
        VALUES 
        (:lawyer_id, :customer_id, :customer_name, :profession, :lawyer_name, :consultation_date, :day, :time)
    ");

    $stmt->execute([
        ':lawyer_id' => $lawyer_id,
        ':customer_id' => $customer_id,
        ':customer_name' => $customer_name,
        ':profession' => $profession,
        ':lawyer_name' => $lawyer,
        ':consultation_date' => $date,
        ':day' => $day,
        ':time' => $time
    ]);

    header("Location: ../consultation/consultation.php?status=success");
    exit;
} catch (PDOException $e) {
    die("Gagal menyimpan data: " . $e->getMessage());
}
?>
