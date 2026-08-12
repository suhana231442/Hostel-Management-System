<?php

header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . "/../config/database.php";

try {

    $stmt = $pdo->query("
        SELECT *
        FROM notices
        ORDER BY id DESC
    ");

    $notices = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "notices" => $notices
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "notices" => [],
        "message" => "Database Error: " . $e->getMessage()
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "notices" => [],
        "message" => $e->getMessage()
    ]);
}

exit;

?>