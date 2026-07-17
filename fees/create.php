<?php

include("../config/database.php");
include("../auth/auth_check.php");

$data = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("INSERT INTO fees
(student_id, amount, fee_type, payment_date, payment_method, status, transaction_reference)
VALUES (?, ?, ?, ?, ?, ?, ?)");

$result = $sql->execute([
    $data["student_id"],
    $data["amount"],
    $data["fee_type"],
    $data["payment_date"],
    $data["payment_method"],
    $data["status"],
    $data["transaction_reference"]
]);

if ($result) {
    echo json_encode([
        "success" => true,
        "message" => "Payment recorded successfully."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Payment failed."
    ]);
}

?>