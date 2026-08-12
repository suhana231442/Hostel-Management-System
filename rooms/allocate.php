<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$student_id = $data["student_id"] ?? "";
$room_id = $data["room_id"] ?? "";

if ($student_id == "" || $room_id == "") {
    echo json_encode([
        "success" => false,
        "message" => "Student ID and Room ID are required"
    ]);
    exit;
}

try {

    $check = $pdo->prepare(
        "SELECT occupied, capacity FROM rooms WHERE id = ?"
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

    if ($room["occupied"] >= $room["capacity"]) {
        echo json_encode([
            "success" => false,
            "message" => "Room is full"
        ]);
        exit;
    }

    $update = $pdo->prepare(
        "UPDATE rooms SET occupied = occupied + 1 WHERE id = ?"
    );

    $update->execute([$room_id]);

    echo json_encode([
        "success" => true,
        "message" => "Room allocated successfully"
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>