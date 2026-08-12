<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

try {

    $stmt = $pdo->query(
        "SELECT * FROM complaints ORDER BY id DESC"
    );

    echo json_encode([
        "success" => true,
        "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "data" => [],
        "message" => $e->getMessage()
    ]);
}
?>