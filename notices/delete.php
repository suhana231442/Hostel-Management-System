<?php

include("../config/database.php");
include("../auth/auth_check.php");

$data = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("DELETE FROM notices WHERE id=?");

$result = $sql->execute([
    $data["id"]
]);

echo json_encode([
    "success" => $result,
    "message" => "Notice Deleted Successfully"
]);

?>