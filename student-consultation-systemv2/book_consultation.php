<?php
declare(strict_types=1);
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/includes/layout.php";

$message = "";
$type = "";

$slotMap = [
    "Mon 09:00-10:00,Mon 14:00-15:00",
    "Tue 10:00-11:00,Tue 15:00-16:00",
    "Wed 09:00-10:00,Thu 13:00-14:00",
    "Fri 10:00-11:00,Fri 14:00-15:00",
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studentId = trim($_POST["student_id"] ?? "");
    $lecturerId = trim($_POST["lecturer_id"] ?? "");
    $consultationDate = trim($_POST["consultation_date"] ?? "");
    $timeSlot = trim($_POST["time_slot"] ?? "");
    $status = trim($_POST["status"] ?? "pending");

    if ($studentId === "" || $lecturerId === "" || $consultationDate === "" || $timeSlot === "") {
        $message = "All fields are required.";
        $type = "error";
    } else {
        try {
            $checkSql = "SELECT COUNT(*) FROM bookings WHERE lecturer_id = ? AND consultation_date = ? AND time_slot = ?";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute([$lecturerId, $consultationDate, $timeSlot]);
            $exists = (int) $checkStmt->fetchColumn();

            if ($exists > 0) {
                $message = "Selected time slot is already booked for this lecturer.";
                $type = "error";
            } else {
                $insertSql = "INSERT INTO bookings (student_id, lecturer_id, consultation_date, time_slot, status)
                              VALUES (?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($insertSql);
                $stmt->execute([$studentId, $lecturerId, $consultationDate, $timeSlot, $status]);
                $message = "Consultation booked successfully.";
                $type = "success";
            }
        } catch (PDOException $e) {
            $message = "Failed to create booking: " . $e->getMessage();
            $type = "error";
        }
    }
}

$students = $pdo->query("SELECT student_id, full_name FROM students ORDER BY full_name")->fetchAll();
$lecturers = $pdo->query("SELECT lecturer_id, full_name FROM lecturers ORDER BY full_name")->fetchAll();

renderHeader("Book Consultation", "book");
?>
<section class="card">
    <h2>Book Consultation</h2>
    <?php if ($message !== ""): ?>
        <div class="message <?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form id="booking-form" method="post">
        <label for="student_id">Student</label>
        <select id="student_id" name="student_id" required>
            <option value="">-- Select Student --</option>
            <?php foreach ($students as $student): ?>
                <option value="<?php echo htmlspecialchars($student["student_id"]); ?>">
                    <?php echo htmlspecialchars($student["full_name"] . " (" . $student["student_id"] . ")"); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="lecturer_id">Lecturer</label>
        <select id="lecturer_id" name="lecturer_id" required>
            <option value="">-- Select Lecturer --</option>
            <?php foreach ($lecturers as $index => $lecturer): ?>
                <option value="<?php echo htmlspecialchars($lecturer["lecturer_id"]); ?>"
                        data-slots="<?php echo htmlspecialchars($slotMap[$index % count($slotMap)]); ?>">
                    <?php echo htmlspecialchars($lecturer["full_name"] . " (" . $lecturer["lecturer_id"] . ")"); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="consultation_date">Consultation Date</label>
        <input type="date" id="consultation_date" name="consultation_date" required>

        <label for="time_slot">Available Time Slots</label>
        <select id="time_slot" name="time_slot" required>
            <option value="">-- Select lecturer first --</option>
        </select>

        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="cancelled">Cancelled</option>
        </select>

        <button type="submit">Book Consultation</button>
    </form>
</section>
<?php renderFooter(); ?>

