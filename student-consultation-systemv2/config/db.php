<?php
declare(strict_types=1);

$dbHost = "127.0.0.1";
$dbName = "student_consultation_db";
$dbUser = "root";
$dbPass = "";
$dbCharset = "utf8mb4";

$dsn = "mysql:host={$dbHost};port=3308;dbname={$dbName};charset={$dbCharset}";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

