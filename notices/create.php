<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$title = $data["title"] ?? "";
$description = $data["description"] ?? "";
$notice_date = $data["notice_date"] ?? date("Y-m-d");

if ($title == "" || $description == "") {

    echo json_encode([
        "success" => false,
        "message" => "Title and description are required"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("
        INSERT INTO notices
        (title, description, notice_date)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $title,
        $description,
        $notice_date
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Notice added successfully"
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>