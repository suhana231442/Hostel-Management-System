CREATE DATABASE IF NOT EXISTS hostel_management;
USE hostel_management;

CREATE TABLE IF NOT EXISTS admins (
 id INT AUTO_INCREMENT PRIMARY KEY,
 email VARCHAR(150) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS students (
 id INT AUTO_INCREMENT PRIMARY KEY,
 student_id VARCHAR(50) NOT NULL UNIQUE,
 full_name VARCHAR(150) NOT NULL,
 date_of_birth DATE,
 gender VARCHAR(30),
 email VARCHAR(150),
 phone VARCHAR(30),
 course VARCHAR(100),
 semester VARCHAR(30),
 guardian_name VARCHAR(150),
 guardian_phone VARCHAR(30),
 registration_date DATE,
 status VARCHAR(30) DEFAULT 'Active',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS rooms (
 id INT AUTO_INCREMENT PRIMARY KEY,
 room_number VARCHAR(30) NOT NULL UNIQUE,
 floor VARCHAR(30),
 room_type VARCHAR(50),
 capacity INT NOT NULL DEFAULT 1,
 occupied_beds INT NOT NULL DEFAULT 0,
 status VARCHAR(30) DEFAULT 'Available'
);

CREATE TABLE IF NOT EXISTS room_allocations (
 id INT AUTO_INCREMENT PRIMARY KEY,
 student_id INT NOT NULL,
 room_id INT NOT NULL,
 bed_number INT NOT NULL,
 allocation_date DATE,
 status VARCHAR(30) DEFAULT 'Allocated',
 FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE,
 FOREIGN KEY(room_id) REFERENCES rooms(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS fees (
 id INT AUTO_INCREMENT PRIMARY KEY,
 student_id INT NOT NULL,
 amount DECIMAL(10,2) NOT NULL,
 fee_type VARCHAR(80),
 payment_date DATE,
 payment_method VARCHAR(50) DEFAULT 'Cash',
 status VARCHAR(30) DEFAULT 'Paid',
 transaction_reference VARCHAR(100),
 FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS complaints (
 id INT AUTO_INCREMENT PRIMARY KEY,
 student_id INT NOT NULL,
 complaint_title VARCHAR(200) NOT NULL,
 complaint_description TEXT,
 category VARCHAR(80),
 complaint_date DATE,
 status VARCHAR(30) DEFAULT 'Pending',
 admin_response TEXT,
 resolved_date DATE,
 FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS notices (
 id INT AUTO_INCREMENT PRIMARY KEY,
 title VARCHAR(200) NOT NULL,
 description TEXT,
 category VARCHAR(80),
 notice_type VARCHAR(50) DEFAULT 'General',
 priority VARCHAR(50) DEFAULT 'Normal',
 expiry_date DATE NULL,
 status VARCHAR(30) DEFAULT 'Active',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO rooms(room_number,floor,room_type,capacity,occupied_beds,status)
SELECT '101','1','Double Sharing',2,0,'Available'
WHERE NOT EXISTS (SELECT 1 FROM rooms WHERE room_number='101');
INSERT INTO rooms(room_number,floor,room_type,capacity,occupied_beds,status)
SELECT '102','1','Triple Sharing',3,0,'Available'
WHERE NOT EXISTS (SELECT 1 FROM rooms WHERE room_number='102');
INSERT INTO rooms(room_number,floor,room_type,capacity,occupied_beds,status)
SELECT '103','1','Triple Sharing',3,0,'Available'
WHERE NOT EXISTS (SELECT 1 FROM rooms WHERE room_number='103');
INSERT INTO rooms(room_number,floor,room_type,capacity,occupied_beds,status)
SELECT '104','1','Double Sharing',2,0,'Available'
WHERE NOT EXISTS (SELECT 1 FROM rooms WHERE room_number='104');

INSERT INTO notices(title,description,category,notice_type,priority,expiry_date,status)
SELECT 'Welcome to Hostel','Welcome to the Hostel Management System.','Services','General', 'Normal', NULL,'Active'
WHERE NOT EXISTS (SELECT 1 FROM notices);
