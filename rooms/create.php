<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

try {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    if (!$data) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid data received"
        ]);
        exit;
    }

    $room_number = trim($data["room_number"] ?? "");
    $floor = trim($data["floor"] ?? "");
    $room_type = trim($data["room_type"] ?? "");
    $capacity = (int)($data["capacity"] ?? 0);
    $occupied_beds = (int)($data["occupied_beds"] ?? 0);
    $status = trim($data["status"] ?? "Available");

    if ($room_number === "") {
        echo json_encode([
            "success" => false,
            "message" => "Room number is required"
        ]);
        exit;
    }

    if ($capacity <= 0) {
        echo json_encode([
            "success" => false,
            "message" => "Room capacity must be greater than 0"
        ]);
        exit;
    }

    if ($occupied_beds < 0 || $occupied_beds > $capacity) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid occupied beds value"
        ]);
        exit;
    }

    $sql = $pdo->prepare("
        INSERT INTO rooms
        (
            room_number,
            floor,
            room_type,
            capacity,
            occupied_beds,
            status
        )
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $result = $sql->execute([
        $room_number,
        $floor,
        $room_type,
        $capacity,
        $occupied_beds,
        $status
    ]);

    echo json_encode([
        "success" => $result,
        "message" => $result
            ? "Room Added Successfully"
            : "Failed to add room"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

?>