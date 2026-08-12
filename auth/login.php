<?php

session_start();

header("Content-Type: application/json");

$email = "";
$password = "";

// Get JSON request
$input = file_get_contents("php://input");

if (!empty($input)) {

    $data = json_decode($input, true);

    if (is_array($data)) {
        $email = trim($data["email"] ?? "");
        $password = trim($data["password"] ?? "");
    }
}

// Demo administrator login
if ($email === "admin@gmail.com" && $password === "admin123") {

    $_SESSION["admin_logged_in"] = true;
    $_SESSION["admin_id"] = 1;
    $_SESSION["admin_email"] = "admin@gmail.com";
    $_SESSION["admin_name"] = "Administrator";
    $_SESSION["logged_in"] = true;

    echo json_encode([
        "success" => true,
        "message" => "Login successful"
    ]);

    exit;
}

// Invalid login
echo json_encode([
    "success" => false,
    "message" => "Invalid login. Use admin@gmail.com / admin123"
]);

exit;

?>