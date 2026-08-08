<?php

include("../config/database.php");
include("../auth/auth_check.php");

$student_id = $_POST['student_id'];
$amount = $_POST['amount'];
$fee_type = $_POST['fee_type'];
$payment_date = $_POST['payment_date'];
$payment_method = $_POST['payment_method'];
$status = $_POST['status'];
$transaction_reference = $_POST['transaction_reference'];

$sql = $conn->prepare("
INSERT INTO fees
(student_id, amount, fee_type, payment_date, payment_method, status, transaction_reference)
VALUES (?, ?, ?, ?, ?, ?, ?)
");

$result = $sql->execute([
    $student_id,
    $amount,
    $fee_type,
    $payment_date,
    $payment_method,
    $status,
    $transaction_reference
]);

if ($result) {
    header("Location: ../pages/fees.html?success=1");
    exit();
} else {
    echo "Payment Failed.";
}

?>