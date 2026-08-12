<?php

header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . "/../config/database.php";

try {

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        throw new Exception("No data received.");
    }

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