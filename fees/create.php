<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

require_once("../config/database.php");

try {

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        throw new Exception("No data received.");
    }

    $student_id = $data["student_id"] ?? "";
    $amount = $data["amount"] ?? "";
    $fee_type = $data["fee_type"] ?? "";
    $payment_date = $data["payment_date"] ?? "";
    $payment_method = $data["payment_method"] ?? "";
    $status = $data["status"] ?? "Paid";
    $transaction_reference = $data["transaction_reference"] ?? "";

    if (
        empty($student_id) ||
        empty($amount) ||
        empty($fee_type) ||
        empty($payment_date) ||
        empty($payment_method)
    ) {
        throw new Exception("Please fill all required fields.");
    }

    $sql = $conn->prepare("
        INSERT INTO fees
        (student_id, amount, fee_type, payment_date, payment_method, status, transaction_reference)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $sql->execute([
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
        "message" => "Payment recorded successfully."
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Database Error: " . $e->getMessage()
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

exit;
?>