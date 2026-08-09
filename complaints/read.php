<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

require_once("../config/database.php");

try {

    $sql = $conn->prepare("
        SELECT
            complaints.*,
            students.full_name
        FROM complaints
        JOIN students
        ON complaints.student_id = students.id
        ORDER BY complaints.id DESC
    ");

    $sql->execute();

    $complaints = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "complaints" => $complaints
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Database Error: " . $e->getMessage()
    ]);

}

exit;
?>