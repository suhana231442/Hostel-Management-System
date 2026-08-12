<?php

require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"] ?? "";
$title = trim($data["title"] ?? "");
$description = trim($data["description"] ?? "");

if (!$id || !$title || !$description) {

    echo json_encode([
        "success" => false,
        "message" => "Required fields missing"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("
        UPDATE notices
        SET title = ?, description = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $title,
        $description,
        $id
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Notice updated successfully"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>