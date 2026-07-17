<?php

include("../config/database.php");

$data = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("UPDATE students SET
student_id=?,
full_name=?,
date_of_birth=?,
gender=?,
email=?,
phone=?,
course=?,
semester=?,
guardian_name=?,
guardian_phone=?,
registration_date=?,
status=?
WHERE id=?");

$result = $sql->execute([
    $data["student_id"],
    $data["full_name"],
    $data["date_of_birth"],
    $data["gender"],
    $data["email"],
    $data["phone"],
    $data["course"],
    $data["semester"],
    $data["guardian_name"],
    $data["guardian_phone"],
    $data["registration_date"],
    $data["status"],
    $data["id"]
]);

echo json_encode([
    "success" => $result
]);

?>