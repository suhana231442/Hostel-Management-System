<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

try {

    $stmt = $pdo->query(
        "SELECT * FROM rooms ORDER BY room_number"
    );

    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $rooms
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "data" => [],
        "message" => $e->getMessage()
    ]);
}

?>