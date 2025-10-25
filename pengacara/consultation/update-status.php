<?php
$pdo = new PDO("mysql:host=localhost;dbname=threebrotherlaw;charset=utf8mb4", "root", "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];

    $status = ($action === 'accept') ? 'Accepted' : 'Rejected';

    $stmt = $pdo->prepare("UPDATE consultation_schedule SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    header("Location: consultation.php");
    exit;
}
?>
