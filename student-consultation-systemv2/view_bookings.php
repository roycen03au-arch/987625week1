<?php
declare(strict_types=1);
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/includes/layout.php";

$message = "";
$type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bookingId = (int) ($_POST["booking_id"] ?? 0);
    $action = trim($_POST["action"] ?? "");

    if ($bookingId > 0 && in_array($action, ["confirm", "cancel"], true)) {
        $newStatus = $action === "confirm" ? "confirmed" : "cancelled";
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
        $stmt->execute([$newStatus, $bookingId]);
        $message = "Booking status updated.";
        $type = "success";
    }
}

$studentFilter = trim($_GET["student_id"] ?? "");
$lecturerFilter = trim($_GET["lecturer_id"] ?? "");
$dateFilter = trim($_GET["consultation_date"] ?? "");

$students = $pdo->query("SELECT student_id, full_name FROM students ORDER BY full_name")->fetchAll();
$lecturers = $pdo->query("SELECT lecturer_id, full_name FROM lecturers ORDER BY full_name")->fetchAll();

$sql = "SELECT b.booking_id, b.consultation_date, b.time_slot, b.status,
               s.full_name AS student_name, s.student_id,
               l.full_name AS lecturer_name, l.lecturer_id
        FROM bookings b
        JOIN students s ON b.student_id = s.student_id
        JOIN lecturers l ON b.lecturer_id = l.lecturer_id
        WHERE 1=1";
$params = [];

if ($studentFilter !== "") {
    $sql .= " AND b.student_id = ?";
    $params[] = $studentFilter;
}
if ($lecturerFilter !== "") {
    $sql .= " AND b.lecturer_id = ?";
    $params[] = $lecturerFilter;
}
if ($dateFilter !== "") {
    $sql .= " AND b.consultation_date = ?";
    $params[] = $dateFilter;
}

$sql .= " ORDER BY b.consultation_date DESC, b.booking_id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$bookings = $stmt->fetchAll();

renderHeader("View Bookings", "view");
?>
<section class="card">
    <h2>View Bookings</h2>

    <?php if ($message !== ""): ?>
        <div class="message <?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="get" class="grid-2">
        <div>
            <label for="student_id">Filter by Student</label>
            <select id="student_id" name="student_id">
                <option value="">All Students</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?php echo htmlspecialchars($student["student_id"]); ?>"
                        <?php echo $studentFilter === $student["student_id"] ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($student["full_name"]); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="lecturer_id">Filter by Lecturer</label>
            <select id="lecturer_id" name="lecturer_id">
                <option value="">All Lecturers</option>
                <?php foreach ($lecturers as $lecturer): ?>
                    <option value="<?php echo htmlspecialchars($lecturer["lecturer_id"]); ?>"
                        <?php echo $lecturerFilter === $lecturer["lecturer_id"] ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($lecturer["full_name"]); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="consultation_date">Filter by Date</label>
            <input type="date" id="consultation_date" name="consultation_date" value="<?php echo htmlspecialchars($dateFilter); ?>">
        </div>
        <div>
            <button type="submit">Apply Filters</button>
        </div>
    </form>
</section>

<section class="card">
    <table>
        <thead>
        <tr>
            <th>Booking ID</th>
            <th>Student</th>
            <th>Lecturer</th>
            <th>Date</th>
            <th>Time Slot</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($bookings) === 0): ?>
            <tr><td colspan="7">No bookings found.</td></tr>
        <?php else: ?>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?php echo (int) $booking["booking_id"]; ?></td>
                    <td><?php echo htmlspecialchars($booking["student_name"] . " (" . $booking["student_id"] . ")"); ?></td>
                    <td><?php echo htmlspecialchars($booking["lecturer_name"] . " (" . $booking["lecturer_id"] . ")"); ?></td>
                    <td><?php echo htmlspecialchars($booking["consultation_date"]); ?></td>
                    <td><?php echo htmlspecialchars($booking["time_slot"]); ?></td>
                    <td><?php echo htmlspecialchars(ucfirst($booking["status"])); ?></td>
                    <td>
                        <form method="post" style="display:inline-block">
                            <input type="hidden" name="booking_id" value="<?php echo (int) $booking["booking_id"]; ?>">
                            <input type="hidden" name="action" value="confirm">
                            <button type="submit">Confirm</button>
                        </form>
                        <form method="post" style="display:inline-block">
                            <input type="hidden" name="booking_id" value="<?php echo (int) $booking["booking_id"]; ?>">
                            <input type="hidden" name="action" value="cancel">
                            <button type="submit">Cancel</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</section>
<?php renderFooter(); ?>

