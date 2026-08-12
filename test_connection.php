<?php

header("Content-Type: application/json");

$host = "127.0.0.1";
$port = "3306";
$dbname = "hostel_management";
$username = "root";
$password = "";

try {

    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    echo json_encode([
        "success" => true,
        "message" => "Database Connected Successfully!"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Database connection failed",
        "error" => $e->getMessage()
    ]);
}
?>