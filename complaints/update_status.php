<?php

require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"] ?? "";
$status = trim($data["status"] ?? "");

if (!$id || !$status) {

    echo json_encode([
        "success" => false,
        "message" => "ID and status are required"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("
        UPDATE complaints
        SET status = ?
        WHERE id = ?
    ");

    $stmt->execute([$status, $id]);

    echo json_encode([
        "success" => true,
        "message" => "Complaint status updated"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>