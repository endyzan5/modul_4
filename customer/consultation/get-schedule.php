<?php
header('Content-Type: application/json');

$pdo = new PDO("mysql:host=localhost;dbname=threebrotherlaw;charset=utf8mb4", "root", "");

// Pastikan parameter lawyer_id ada
if (!isset($_GET['lawyer_id'])) {
    echo json_encode([]);
    exit;
}

$lawyer_id = $_GET['lawyer_id'];

// Ambil jadwal dari tabel lawyer_schedule
$stmt = $pdo->prepare("SELECT day, start_time, end_time FROM lawyer_schedule WHERE lawyer_id = ?");
$stmt->execute([$lawyer_id]);
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($schedules);
?>
