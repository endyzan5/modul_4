<?php
header('Content-Type: application/json');
require_once '../../config.php'; // gunakan koneksi dari config.php

try {
    // Pastikan koneksi tersedia
    if (!isset($pdo)) {
        throw new Exception("Database connection not found.");
    }

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

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
