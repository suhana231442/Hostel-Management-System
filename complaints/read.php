<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

try {

    $stmt = $pdo->query("
        SELECT
            complaints.*,
            students.full_name
        FROM complaints
        LEFT JOIN students
            ON complaints.student_id = students.id
        ORDER BY complaints.id DESC
    ");

    $complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $complaints,
        "complaints" => $complaints
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "data" => [],
        "complaints" => [],
        "message" => "Database Error: " . $e->getMessage()
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "data" => [],
        "complaints" => [],
        "message" => $e->getMessage()
    ]);
}

exit;

?>