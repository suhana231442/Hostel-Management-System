<?php
session_start();
error_log("LOGIN SESSION ID: " . session_id());

include("../config/database.php");

// Read JSON data from frontend
$data = json_decode(file_get_contents("php://input"), true);

// Check if email and password are provided
if (!isset($data["email"]) || !isset($data["password"])) {
    echo json_encode([
        "success" => false,
        "message" => "Email and Password are required"
    ]);
    exit();
}

$email = $data["email"];
$password = $data["password"];

// Find admin by email
$sql = $conn->prepare("SELECT * FROM admins WHERE email = ?");
$sql->execute([$email]);

$admin = $sql->fetch(PDO::FETCH_ASSOC);

// Verify password
if ($admin && password_verify($password, $admin["password"])) {

    $_SESSION["admin_id"] = $admin["id"];

    echo json_encode([
        "success" => true,
        "message" => "Login Successful"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Invalid Email or Password"
    ]);
}
?>