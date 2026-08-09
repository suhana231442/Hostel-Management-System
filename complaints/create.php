<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

require_once("../config/database.php");

try {

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        throw new Exception("No data received.");
    }

    $student_id = $data["student_id"] ?? "";
    $complaint_title = $data["complaint_title"] ?? "";
    $complaint_description = $data["complaint_description"] ?? "";
    $category = $data["category"] ?? "";

    if (
        empty($student_id) ||
        empty($complaint_title) ||
        empty($complaint_description) ||
        empty($category)
    ) {
        throw new Exception("Please fill all fields.");
    }

    $sql = $conn->prepare("
        INSERT INTO complaints
        (student_id, complaint_title, complaint_description, category, complaint_date, status)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $result = $sql->execute([
        $student_id,
        $complaint_title,
        $complaint_description,
        $category,
        date("Y-m-d"),
        "Pending"
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Complaint Submitted Successfully"
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