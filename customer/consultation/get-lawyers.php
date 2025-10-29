<?php
header('Content-Type: application/json');
require_once '../../config.php'; // panggil koneksi dari file config.php

try {
    // Pastikan variabel $pdo tersedia dari config.php
    if (!isset($pdo)) {
        throw new Exception("Database connection not found.");
    }

    // Ambil parameter profession dari URL
    $profession = $_GET['profession'] ?? '';

    // Siapkan dan jalankan query
    $stmt = $pdo->prepare("SELECT id, full_name FROM lawyers WHERE profession = ?");
    $stmt->execute([$profession]);

    // Ambil hasilnya
    $lawyers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($lawyers);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
