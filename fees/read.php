<?php

include("../config/database.php");
include("../auth/auth_check.php");

$sql = $conn->prepare("
SELECT
fees.*,
students.full_name
FROM fees
JOIN students
ON fees.student_id = students.id
ORDER BY fees.id DESC
");

$sql->execute();

$payments = $sql->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "payments" => $payments
]);

?>