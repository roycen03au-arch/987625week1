<?php
declare(strict_types=1);
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/includes/layout.php";

$message = "";
$type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studentId = trim($_POST["student_id"] ?? "");
    $fullName = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");

    if ($studentId === "" || $fullName === "" || $email === "" || $phone === "") {
        $message = "All fields are required.";
        $type = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
        $type = "error";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO students (student_id, full_name, email, phone) VALUES (?, ?, ?, ?)");
            $stmt->execute([$studentId, $fullName, $email, $phone]);
            $message = "Student registered successfully.";
            $type = "success";
        } catch (PDOException $e) {
            $message = "Failed to register student: " . $e->getMessage();
            $type = "error";
        }
    }
}

renderHeader("Register Student", "register-student");
?>
<section class="card">
    <h2>Register Student</h2>
    <?php if ($message !== ""): ?>
        <div class="message <?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form id="student-form" method="post">
        <label for="student_id">Student ID</label>
        <input type="text" id="student_id" name="student_id" required>

        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" required>

        <button type="submit">Submit</button>
    </form>
</section>
<?php renderFooter(); ?>

