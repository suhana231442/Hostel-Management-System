<?php

include("../config/database.php");
include("../auth/auth_check.php");

$data=json_decode(file_get_contents("php://input"),true);

// Check room
$check=$conn->prepare("SELECT * FROM rooms WHERE id=?");
$check->execute([$data["room_id"]]);

$room=$check->fetch(PDO::FETCH_ASSOC);

if(!$room){
    echo json_encode([
        "success"=>false,
        "message"=>"Room not found"
    ]);
    exit();
}

if($room["occupied_beds"] >= $room["capacity"]){

    echo json_encode([
        "success"=>false,
        "message"=>"Room is Full"
    ]);

    exit();
}

// Allocate room

$sql=$conn->prepare("INSERT INTO room_allocations
(student_id,room_id,bed_number,allocation_date,status)
VALUES(?,?,?,?,?)");

$sql->execute([
    $data["student_id"],
    $data["room_id"],
    $room["occupied_beds"] + 1
    date("Y-m-d"),
    "Allocated"
]);

// Update occupied beds

$conn->prepare("UPDATE rooms SET occupied_beds=occupied_beds+1 WHERE id=?")
     ->execute([$data["room_id"]]);

echo json_encode([
    "success"=>true,
    "message"=>"Room Allocated Successfully"
]);

?>