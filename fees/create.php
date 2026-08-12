<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$student_id = $data["student_id"] ?? "";
$amount = $data["amount"] ?? 0;
$fee_type = $data["fee_type"] ?? "Hostel Fee";
$payment_date = $data["payment_date"] ?? date("Y-m-d");
$payment_method = $data["payment_method"] ?? "Cash";
$status = $data["status"] ?? "Paid";
$transaction_reference = $data["transaction_reference"] ?? "";

if ($student_id == "" || $amount <= 0) {

    echo json_encode([
        "success" => false,
        "message" => "Student ID and amount are required"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("
        INSERT INTO fees
        (student_id, amount, fee_type, payment_date,
         payment_method, status, transaction_reference)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $student_id,
        $amount,
        $fee_type,
        $payment_date,
        $payment_method,
        $status,
        $transaction_reference
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Payment added successfully"
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>