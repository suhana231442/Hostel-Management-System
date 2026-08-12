<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$room_id = $data["room_id"] ?? "";

if ($room_id === "") {

    echo json_encode([
        "success" => false,
        "message" => "Room ID is required"
    ]);

    exit;
}

try {

    // Check whether the room exists
    $check = $pdo->prepare(
        "SELECT id, occupied FROM rooms WHERE id = ?"
    );

    $check->execute([$room_id]);

    $room = $check->fetch(PDO::FETCH_ASSOC);

    if (!$room) {

        echo json_encode([
            "success" => false,
            "message" => "Room not found"
        ]);

        exit;
    }

    // Check if the room has any occupied beds
    if ((int)$room["occupied"] <= 0) {

        echo json_encode([
            "success" => false,
            "message" => "Room is already empty"
        ]);

        exit;
    }

    // Decrease occupied count by 1
    $stmt = $pdo->prepare("
        UPDATE rooms
        SET occupied = occupied - 1
        WHERE id = ?
    ");

    $stmt->execute([$room_id]);

    echo json_encode([
        "success" => true,
        "message" => "Room deallocated successfully"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Deallocation failed: " . $e->getMessage()
    ]);
}

?>