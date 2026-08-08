<?php

include("../config/database.php");

$student_id = $_POST['student_id'];
$full_name = $_POST['full_name'];
$date_of_birth = $_POST['date_of_birth'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$course = $_POST['course'];
$semester = $_POST['semester'];
$address = $_POST['address'];
$guardian_name = $_POST['guardian_name'];
$guardian_phone = $_POST['guardian_phone'];
$registration_date = $_POST['registration_date'];
$status = $_POST['status'];

$sql = $conn->prepare("
INSERT INTO students
(student_id, full_name, date_of_birth, gender, email, phone, course, semester, address, guardian_name, guardian_phone, registration_date, status)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");


$result = $sql->execute([
    $student_id,
    $full_name,
    $date_of_birth,
    $gender,
    $email,
    $phone,
    $course,
    $semester,
    $address,
    $guardian_name,
    $guardian_phone,
    $registration_date,
    $status
]);

if($result){
    header("Location: ../pages/students.php?success=1");
    exit();
}else{
    echo "Registration Failed";
}
?>