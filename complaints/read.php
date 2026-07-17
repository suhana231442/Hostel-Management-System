<?php

include("../config/database.php");
include("../auth/auth_check.php");

$sql = $conn->prepare("
SELECT
complaints.*,
students.full_name
FROM complaints
JOIN students
ON complaints.student_id = students.id
ORDER BY complaints.id DESC
");

$sql->execute();

$complaints = $sql->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success"=>true,
    "complaints"=>$complaints
]);

?>