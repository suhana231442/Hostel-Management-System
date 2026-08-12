<?php

header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . "/../config/database.php";

try {

    $stmt = $pdo->query("
        SELECT
            fees.*,
            students.full_name
        FROM fees
        JOIN students
        ON fees.student_id = students.id
        ORDER BY fees.id DESC
    ");

    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "payments" => $payments
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "payments" => [],
        "message" => "Database Error: " . $e->getMessage()
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "payments" => [],
        "message" => $e->getMessage()
    ]);
}

exit;

?>