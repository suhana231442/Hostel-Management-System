<?php

include("../config/database.php");
include("../auth/auth_check.php");

$data=json_decode(file_get_contents("php://input"),true);

// Update allocation status

$conn->prepare("UPDATE room_allocations
SET status='Deallocated'
WHERE id=?")->execute([$data["allocation_id"]]);

// Reduce occupied beds

$conn->prepare("UPDATE rooms
SET occupied_beds=occupied_beds-1
WHERE id=?")->execute([$data["room_id"]]);

echo json_encode([
    "success"=>true,
    "message"=>"Room Deallocated Successfully"
]);

?>