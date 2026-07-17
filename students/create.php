<?php

include("../config/database.php");


// Get JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Prepare SQL
$sql = $conn->prepare("INSERT INTO students
(student_id, full_name, date_of_birth, gender, email, phone, course, semester, guardian_name, guardian_phone, registration_date, status)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Execute
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
    $data["status"]
]);

if($result){

    echo json_encode([
        "success"=>true,
        "message"=>"Student Registered Successfully"
    ]);

}else{

    echo json_encode([
        "success"=>false,
        "message"=>"Registration Failed"
    ]);

}

?>