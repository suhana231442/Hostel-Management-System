<?php

require_once("../config/database.php");

$email = "admin@gmail.com";
$password = password_hash("admin123", PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "INSERT INTO admins (email, password) VALUES (?, ?)"
);

try {

    if ($stmt->execute([$email, $password])) {

        echo "Admin account created successfully!";

    } else {

        echo "Failed to create admin account.";

    }

} catch (PDOException $e) {

    echo "Admin may already exist or database error occurred.";

}

?>