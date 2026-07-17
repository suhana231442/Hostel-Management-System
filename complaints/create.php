<?php

include("../config/database.php");
include("../auth/auth_check.php");

$data = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("INSERT INTO complaints
(student_id, complaint_title, complaint_description, category, complaint_date, status)
VALUES (?, ?, ?, ?, ?, ?)");

$result = $sql->execute([
    $data["student_id"],
    $data["complaint_title"],
    $data["complaint_description"],
    $data["category"],
    date("Y-m-d"),
    "Pending"
]);

if($result){

    echo json_encode([
        "success"=>true,
        "message"=>"Complaint Submitted Successfully"
    ]);

}else{

    echo json_encode([
        "success"=>false,
        "message"=>"Failed to Submit Complaint"
    ]);

}

?>