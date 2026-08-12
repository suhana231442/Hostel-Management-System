<?php

require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$room_id = $data["room_id"] ?? "";

if (!$room_id) {

    echo json_encode([
        "success" => false,
        "message" => "Room ID is required"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("
        UPDATE rooms
        SET occupied = CASE
            WHEN occupied > 0 THEN occupied - 1
            ELSE 0
        END
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
        "message" => $e->getMessage()
    ]);
}
?><?php

require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$room_id = $data["room_id"] ?? "";

if (!$room_id) {

    echo json_encode([
        "success" => false,
        "message" => "Room ID is required"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("
        UPDATE rooms
        SET occupied = CASE
            WHEN occupied > 0 THEN occupied - 1
            ELSE 0
        END
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
        "message" => $e->getMessage()
    ]);
}
?><?php

require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$room_id = $data["room_id"] ?? "";

if (!$room_id) {

    echo json_encode([
        "success" => false,
        "message" => "Room ID is required"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("
        UPDATE rooms
        SET occupied = CASE
            WHEN occupied > 0 THEN occupied - 1
            ELSE 0
        END
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
        "message" => $e->getMessage()
    ]);
}
?><?php

require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$room_id = $data["room_id"] ?? "";

if (!$room_id) {

    echo json_encode([
        "success" => false,
        "message" => "Room ID is required"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("
        UPDATE rooms
        SET occupied = CASE
            WHEN occupied > 0 THEN occupied - 1
            ELSE 0
        END
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
        "message" => $e->getMessage()
    ]);
}
?><?php

require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$room_id = $data["room_id"] ?? "";

if (!$room_id) {

    echo json_encode([
        "success" => false,
        "message" => "Room ID is required"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("
        UPDATE rooms
        SET occupied = CASE
            WHEN occupied > 0 THEN occupied - 1
            ELSE 0
        END
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
        "message" => $e->getMessage()
    ]);
}
?><?php

require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$room_id = $data["room_id"] ?? "";

if (!$room_id) {

    echo json_encode([
        "success" => false,
        "message" => "Room ID is required"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("
        UPDATE rooms
        SET occupied = CASE
            WHEN occupied > 0 THEN occupied - 1
            ELSE 0
        END
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
        "message" => $e->getMessage()
    ]);
}
?><?php

require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$room_id = $data["room_id"] ?? "";

if (!$room_id) {

    echo json_encode([
        "success" => false,
        "message" => "Room ID is required"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("
        UPDATE rooms
        SET occupied = CASE
            WHEN occupied > 0 THEN occupied - 1
            ELSE 0
        END
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
        "message" => $e->getMessage()
    ]);
}
?>