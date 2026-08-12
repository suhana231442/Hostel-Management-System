<?php

require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"] ?? "";

if (!$id) {

    echo json_encode([
        "success" => false,
        "message" => "Notice ID required"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("DELETE FROM notices WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode([
        "success" => true,
        "message" => "Notice deleted successfully"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>