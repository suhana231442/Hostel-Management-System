<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$student_id = $data["student_id"] ?? "";
$student_name = $data["student_name"] ?? "";
$title = $data["complaint_title"] ?? $data["title"] ?? "";
$category = $data["category"] ?? "";
$description = $data["description"] ?? "";

if (
    $student_id == "" ||
    $student_name == "" ||
    $title == "" ||
    $description == ""
) {

    echo json_encode([
        "success" => false,
        "message" => "Please fill all required fields"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("
        INSERT INTO complaints
        (student_id, student_name, complaint_title,
         category, description, status)
        VALUES (?, ?, ?, ?, ?, 'Pending')
    ");

    $stmt->execute([
        $student_id,
        $student_name,
        $title,
        $category,
        $description
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Complaint added successfully"
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>