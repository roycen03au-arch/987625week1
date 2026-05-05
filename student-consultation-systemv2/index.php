<?php
declare(strict_types=1);
require_once __DIR__ . "/includes/layout.php";
renderHeader("Home", "index");
?>
<section class="card">
    <h2>Welcome</h2>
    <p>This system helps students book consultation sessions with lecturers in a structured way.</p>
    <p>Use the pages below to register users, create bookings, and view all booking records.</p>
</section>

<section class="grid-2">
    <article class="card">
        <h3>Quick Actions</h3>
        <ul>
            <li><a href="register_student.php">Register Student</a></li>
            <li><a href="register_lecturer.php">Register Lecturer</a></li>
            <li><a href="book_consultation.php">Book Consultation</a></li>
            <li><a href="view_bookings.php">View Bookings</a></li>
        </ul>
    </article>
    <article class="card">
        <h3>Version 1 Scope</h3>
        <p>No login is required. Students and lecturers are selected by dropdown during booking.</p>
        <p>Core functions include insert, retrieve, and booking status update/cancel.</p>
    </article>
</section>
<?php renderFooter(); ?>

