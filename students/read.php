<?php

header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . "/../config/database.php";

try {

    $sql = $pdo->prepare("
        SELECT
            student_id,
            full_name,
            date_of_birth,
            gender,
            email,
            phone,
            course,
            semester,
            guardian_name,
            guardian_phone,
            registration_date,
            status
        FROM students
        ORDER BY student_id DESC
    ");

    $sql->execute();

    $students = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "students" => $students
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "students" => [],
        "message" => "Database error: " . $e->getMessage()
    ]);
}

?>