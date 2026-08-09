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

    $sql = $conn->prepare("
        UPDATE complaints
        SET
            status = ?,
            admin_response = ?,
            resolved_date = ?
        WHERE id = ?
    ");

    $result = $sql->execute([
        $data["status"],
        $data["admin_response"] ?? "",
        date("Y-m-d"),
        $data["id"]
    ]);

    echo json_encode([
        "success" => $result,
        "message" => "Complaint Updated Successfully"
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