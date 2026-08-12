<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

try {

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        throw new Exception("No data received.");
    }

    $student_id = $data["student_id"] ?? "";
    $student_name = $data["student_name"] ?? "";
    $complaint_title = $data["complaint_title"] ?? $data["title"] ?? "";
    $category = $data["category"] ?? "";
    $complaint_description =
        $data["complaint_description"] ??
        $data["description"] ??
        "";

    if (
        empty($student_id) ||
        empty($complaint_title) ||
        empty($complaint_description) ||
        empty($category)
    ) {
        throw new Exception("Please fill all required fields.");
    }

    $stmt = $pdo->prepare("
        INSERT INTO complaints
        (
            student_id,
            student_name,
            complaint_title,
            category,
            description,
            status
        )
        VALUES (?, ?, ?, ?, ?, 'Pending')
    ");

    $stmt->execute([
        $student_id,
        $student_name,
        $complaint_title,
        $category,
        $complaint_description
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Complaint added successfully."
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Database Error: " . $e->getMessage()
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

exit;

?>