<?php

include("../config/database.php");
include("../auth/auth_check.php");

$sql=$conn->prepare("SELECT * FROM rooms ORDER BY room_number");
$sql->execute();

$rooms=$sql->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success"=>true,
    "rooms"=>$rooms
]);

?>