<?php
header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=threebrotherlaw;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $profession = $_GET['profession'] ?? '';

    $stmt = $pdo->prepare("SELECT id, full_name FROM lawyers WHERE profession = ?");
    $stmt->execute([$profession]);

    $lawyers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($lawyers);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
