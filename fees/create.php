<?php

header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . "/../config/database.php";

try {

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        throw new Exception("No data received.");
    }

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

    $stmt = $pdo->prepare("
        INSERT INTO fees
        (
            student_id,
            amount,
            fee_type,
            payment_date,
            payment_method,
            status,
            transaction_reference
        )
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