<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request data"
    ]);
    exit;
}

if (!isset($data["id"]) || empty($data["id"])) {
    echo json_encode([
        "success" => false,
        "message" => "Student ID is required"
    ]);
    exit;
}

try {

    $sql = $pdo->prepare("
        UPDATE students SET
            student_id = ?,
            full_name = ?,
            date_of_birth = ?,
            gender = ?,
            email = ?,
            phone = ?,
            course = ?,
            semester = ?,
            guardian_name = ?,
            guardian_phone = ?,
            registration_date = ?,
            status = ?
        WHERE id = ?
    ");

    $result = $sql->execute([
        $data["student_id"] ?? "",
        $data["full_name"] ?? "",
        $data["date_of_birth"] ?? "",
        $data["gender"] ?? "",
        $data["email"] ?? "",
        $data["phone"] ?? "",
        $data["course"] ?? "",
        $data["semester"] ?? "",
        $data["guardian_name"] ?? "",
        $data["guardian_phone"] ?? "",
        $data["registration_date"] ?? date("Y-m-d"),
        $data["status"] ?? "Active",
        $data["id"]
    ]);

    echo json_encode([
        "success" => $result,
        "message" => $result
            ? "Student updated successfully"
            : "Failed to update student"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Database error"
    ]);
}

?>