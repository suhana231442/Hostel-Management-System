<?php

session_start();

include("../auth/auth_check.php");

include("../config/database.php");

$totalStudents = $conn->query("SELECT COUNT(*) FROM students")->fetchColumn();

$totalRooms = $conn->query("SELECT COUNT(*) FROM rooms")->fetchColumn();

$occupiedRooms = $conn->query("SELECT COUNT(*) FROM rooms WHERE occupied_beds > 0")->fetchColumn();

$availableRooms = $conn->query("SELECT COUNT(*) FROM rooms WHERE occupied_beds < capacity")->fetchColumn();

$pendingFees = $conn->query("SELECT COUNT(*) FROM fees WHERE status='Pending'")->fetchColumn();

$pendingComplaints = $conn->query("SELECT COUNT(*) FROM complaints WHERE status='Pending'")->fetchColumn();

$recentNotices = $conn->query("
SELECT title, created_at
FROM notices
ORDER BY created_at DESC
LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "total_students" => $totalStudents,
    "total_rooms" => $totalRooms,
    "occupied_rooms" => $occupiedRooms,
    "available_rooms" => $availableRooms,
    "pending_fees" => $pendingFees,
    "pending_complaints" => $pendingComplaints,
    "recent_notices" => $recentNotices
]);

?>