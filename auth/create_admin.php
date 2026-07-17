<?php

include("../config/database.php");

$email = "admin@gmail.com";
$password = password_hash("admin123", PASSWORD_DEFAULT);

$sql = $conn->prepare("INSERT INTO admins (email, password) VALUES (?, ?)");

if ($sql->execute([$email, $password])) {
    echo "Admin account created successfully!";
} else {
    echo "Failed to create admin account.";
}

?>