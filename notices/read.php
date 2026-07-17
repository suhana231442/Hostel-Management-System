<?php

include("../config/database.php");
include("../auth/auth_check.php");

$sql = $conn->prepare("
SELECT *
FROM notices
WHERE status='Active'
AND (expiry_date IS NULL OR expiry_date >= CURDATE())
ORDER BY created_at DESC
");

$sql->execute();

$notices = $sql->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "notices" => $notices
]);

?>