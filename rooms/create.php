<?php

include("../config/database.php");
include("../auth/auth_check.php");

$data = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("INSERT INTO rooms
(room_number,floor,room_type,capacity,occupied_beds,status)
VALUES(?,?,?,?,?,?)");

$result = $sql->execute([
    $data["room_number"],
    $data["floor"],
    $data["room_type"],
    $data["capacity"],
    $data["occupied_beds"],
    $data["status"]
]);

echo json_encode([
    "success"=>$result,
    "message"=>$result ? "Room Added Successfully" : "Failed"
]);

?>