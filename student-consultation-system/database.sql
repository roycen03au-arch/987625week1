CREATE DATABASE IF NOT EXISTS student_consultation_db;
USE student_consultation_db;

CREATE TABLE IF NOT EXISTS students (
    student_id VARCHAR(20) PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    phone VARCHAR(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS lecturers (
    lecturer_id VARCHAR(20) PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    specialization VARCHAR(120) NOT NULL
);

CREATE TABLE IF NOT EXISTS bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL,
    lecturer_id VARCHAR(20) NOT NULL,
    consultation_date DATE NOT NULL,
    time_slot VARCHAR(50) NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_bookings_student FOREIGN KEY (student_id) REFERENCES students(student_id),
    CONSTRAINT fk_bookings_lecturer FOREIGN KEY (lecturer_id) REFERENCES lecturers(lecturer_id),
    CONSTRAINT uq_lecturer_slot UNIQUE (lecturer_id, consultation_date, time_slot)
);

