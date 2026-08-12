<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data["id"]) || empty($data["id"])) {
    echo json_encode([
        "success" => false,
        "message" => "Student ID is required"
    ]);
    exit;
}

try {

    $stmt = $pdo->prepare(
        "DELETE FROM students WHERE id = ?"
    );

    $stmt->execute([
        $data["id"]
    ]);

    if ($stmt->rowCount() > 0) {

        echo json_encode([
            "success" => true,
            "message" => "Student deleted successfully"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Student not found"
        ]);
    }

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Database error"
    ]);
}

?>