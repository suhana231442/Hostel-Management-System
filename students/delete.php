<?php

include("../config/database.php");
include("../config/database.php");

$data = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("DELETE FROM students WHERE id=?");

$result = $sql->execute([
    $data["id"]
]);

echo json_encode([
    "success" => $result
]);

?>