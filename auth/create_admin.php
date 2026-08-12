<?php
require_once("../config/database.php");

$email = "admin@gmail.com";
$password = password_hash("admin.123", PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE admins SET password = ? WHERE email = ?");
$stmt->execute([$password, $email]);

if ($stmt->rowCount() > 0) {
    echo "PASSWORD RESET SUCCESSFULLY";
} else {
    echo "Admin not found. Run setup.sql first.";
}
?>