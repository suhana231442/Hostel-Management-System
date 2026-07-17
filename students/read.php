<?php


include("../config/database.php");


// Read all students
$sql = $conn->prepare("SELECT * FROM students ORDER BY id DESC");
$sql->execute();

$students = $sql->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "students" => $students
]);

?>