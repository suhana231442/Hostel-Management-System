<?php

include("../config/database.php");
include("../auth/auth_check.php");

$data = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("INSERT INTO notices
(title, description, category, notice_type, priority, expiry_date, status)
VALUES (?, ?, ?, ?, ?, ?, ?)");

$result = $sql->execute([
    $data["title"],
    $data["description"],
    $data["category"],
    $data["notice_type"],
    $data["priority"],
    $data["expiry_date"],
    $data["status"]
]);

echo json_encode([
    "success" => $result,
    "message" => $result ? "Notice Created Successfully" : "Failed to Create Notice"
]);

?>