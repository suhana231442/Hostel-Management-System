<?php

header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . "/../config/database.php";

try {

    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data["id"] ?? "";

    if (!$id) {

        echo json_encode([
            "success" => false,
            "message" => "Notice ID required"
        ]);

        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM notices WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode([
        "success" => true,
        "message" => "Notice deleted successfully"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Database Error: " . $e->getMessage()
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

exit;

?>