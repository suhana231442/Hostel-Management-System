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

    $id = $data["id"] ?? "";
    $status = trim($data["status"] ?? "");
    $admin_response = $data["admin_response"] ?? "";

    if (!$id || !$status) {
        throw new Exception("ID and status are required.");
    }

    $stmt = $pdo->prepare("
        UPDATE complaints
        SET
            status = ?,
            admin_response = ?,
            resolved_date = ?
        WHERE id = ?
    ");

    $result = $stmt->execute([
        $status,
        $admin_response,
        date("Y-m-d"),
        $id
    ]);

    echo json_encode([
        "success" => $result,
        "message" => "Complaint updated successfully"
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