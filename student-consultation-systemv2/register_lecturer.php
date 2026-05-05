<?php
declare(strict_types=1);
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/includes/layout.php";

$message = "";
$type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lecturerId = trim($_POST["lecturer_id"] ?? "");
    $fullName = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $specialization = trim($_POST["specialization"] ?? "");

    if ($lecturerId === "" || $fullName === "" || $email === "" || $specialization === "") {
        $message = "All fields are required.";
        $type = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
        $type = "error";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO lecturers (lecturer_id, full_name, email, specialization) VALUES (?, ?, ?, ?)");
            $stmt->execute([$lecturerId, $fullName, $email, $specialization]);
            $message = "Lecturer registered successfully.";
            $type = "success";
        } catch (PDOException $e) {
            $message = "Failed to register lecturer: " . $e->getMessage();
            $type = "error";
        }
    }
}

renderHeader("Register Lecturer", "register-lecturer");
?>
<section class="card">
    <h2>Register Lecturer</h2>
    <?php if ($message !== ""): ?>
        <div class="message <?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form id="lecturer-form" method="post">
        <label for="lecturer_id">Lecturer ID</label>
        <input type="text" id="lecturer_id" name="lecturer_id" required>

        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="specialization">Specialization</label>
        <input type="text" id="specialization" name="specialization" required>

        <button type="submit">Submit</button>
    </form>
</section>
<?php renderFooter(); ?>

