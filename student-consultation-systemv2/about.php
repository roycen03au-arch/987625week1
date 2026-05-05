<?php
declare(strict_types=1);
require_once __DIR__ . "/includes/layout.php";
renderHeader("About", "about");
?>
<section class="card">
    <h2>Purpose</h2>
    <p>Student consultation booking is often handled through scattered chats or email messages.
        This project centralizes booking data and reduces schedule conflicts for both students and lecturers.</p>
</section>

<section class="card">
    <h2>How to Use</h2>
    <ol>
        <li>Register students and lecturers.</li>
        <li>Create bookings from the Book Consultation page.</li>
        <li>View, filter, and update booking status on View Bookings page.</li>
    </ol>
</section>

<section class="card">
    <h2>Technology Scope</h2>
    <p>HTML5, CSS3, JavaScript for frontend; PHP and MySQL for backend data management.</p>
</section>
<?php renderFooter(); ?>

