<?php

include("../config/database.php");
include("../auth/auth_check.php");

$data = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("UPDATE complaints
SET
status=?,
admin_response=?,
resolved_date=?
WHERE id=?");

$result = $sql->execute([
    $data["status"],
    $data["admin_response"],
    date("Y-m-d"),
    $data["id"]
]);

echo json_encode([
    "success"=>$result,
    "message"=>"Complaint Updated Successfully"
]);

?>