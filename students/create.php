<?php

header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . "/../config/database.php";

try {

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        throw new Exception("Invalid request data.");
    }

    $student_id = trim($data["student_id"] ?? "");
    $full_name = trim($data["full_name"] ?? "");
    $date_of_birth = $data["date_of_birth"] ?? "";
    $gender = $data["gender"] ?? "";
    $email = trim($data["email"] ?? "");
    $phone = trim($data["phone"] ?? "");
    $course = trim($data["course"] ?? "");
    $semester = trim($data["semester"] ?? "");
    $guardian_name = trim($data["guardian_name"] ?? "");
    $guardian_phone = trim($data["guardian_phone"] ?? "");
    $registration_date = $data["registration_date"] ?? date("Y-m-d");
    $status = $data["status"] ?? "Active";

    if (
        $student_id === "" ||
        $full_name === "" ||
        $date_of_birth === "" ||
        $gender === "" ||
        $email === "" ||
        $phone === "" ||
        $course === "" ||
        $semester === "" ||
        $guardian_name === "" ||
        $guardian_phone === ""
    ) {
        throw new Exception("Please fill all required fields.");
    }

    // Check duplicate Student ID
    $check = $pdo->prepare(
        "SELECT student_id FROM students WHERE student_id = ?"
    );

    $check->execute([$student_id]);

    if ($check->fetch()) {
        throw new Exception("Student ID already exists.");
    }

    // Insert student
    $sql = "INSERT INTO students
    (
        student_id,
        full_name,
        date_of_birth,
        gender,
        email,
        phone,
        course,
        semester,
        guardian_name,
        guardian_phone,
        registration_date,
        status
    )
    VALUES
    (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $student_id,
        $full_name,
        $date_of_birth,
        $gender,
        $email,
        $phone,
        $course,
        $semester,
        $guardian_name,
        $guardian_phone,
        $registration_date,
        $status
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Student registered successfully."
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>