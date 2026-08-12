```php
<?php

header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

require_once __DIR__ . "/../config/database.php";

try {

    // Total registered students
    $totalStudents = $pdo
        ->query("SELECT COUNT(*) FROM students")
        ->fetchColumn();


    // Total rooms
    $totalRooms = $pdo
        ->query("SELECT COUNT(*) FROM rooms")
        ->fetchColumn();


    // Occupied rooms
    $occupiedRooms = $pdo
        ->query("
            SELECT COUNT(*)
            FROM rooms
            WHERE occupied_beds > 0
        ")
        ->fetchColumn();


    // Available rooms
    $availableRooms = $pdo
        ->query("
            SELECT COUNT(*)
            FROM rooms
            WHERE occupied_beds < capacity
        ")
        ->fetchColumn();


    // Pending fees
    $pendingFees = $pdo
        ->query("
            SELECT COUNT(*)
            FROM fees
            WHERE status = 'Pending'
        ")
        ->fetchColumn();


    // Pending complaints
    $pendingComplaints = $pdo
        ->query("
            SELECT COUNT(*)
            FROM complaints
            WHERE status = 'Pending'
        ")
        ->fetchColumn();


    // Recent notices
    $recentNotices = $pdo
        ->query("
            SELECT title, created_at
            FROM notices
            ORDER BY created_at DESC
            LIMIT 5
        ")
        ->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode([

        "success" => true,

        "total_students" => (int)$totalStudents,

        "total_rooms" => (int)$totalRooms,

        "occupied_rooms" => (int)$occupiedRooms,

        "available_rooms" => (int)$availableRooms,

        "pending_fees" => (int)$pendingFees,

        "pending_complaints" => (int)$pendingComplaints,

        "recent_notices" => $recentNotices

    ]);


} catch (PDOException $e) {

    echo json_encode([

        "success" => false,

        "message" => "Dashboard database error",

        "error" => $e->getMessage()

    ]);

}

?>
```
