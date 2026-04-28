<?php
declare(strict_types=1);

function renderHeader(string $title, string $activePage): void
{
    $pages = [
        "index" => ["label" => "Home", "url" => "index.php"],
        "about" => ["label" => "About", "url" => "about.php"],
        "register-student" => ["label" => "Register Student", "url" => "register_student.php"],
        "register-lecturer" => ["label" => "Register Lecturer", "url" => "register_lecturer.php"],
        "book" => ["label" => "Book Consultation", "url" => "book_consultation.php"],
        "view" => ["label" => "View Bookings", "url" => "view_bookings.php"],
        "contact" => ["label" => "Contact", "url" => "contact.php"],
    ];
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($title); ?> - Student Consultation Booking</title>
        <link rel="stylesheet" href="assets/style.css">
    </head>
    <body>
    <header class="site-header">
        <div class="container">
            <h1>Student Consultation Booking System</h1>
            <p class="subtitle">ICT312 - Web Information System Project</p>
            <nav>
                <ul class="nav-list">
                    <?php foreach ($pages as $key => $page): ?>
                        <li>
                            <a class="<?php echo $key === $activePage ? "active" : ""; ?>"
                               href="<?php echo $page["url"]; ?>">
                                <?php echo htmlspecialchars($page["label"]); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">
    <?php
}

function renderFooter(): void
{
    ?>
    </main>
    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Student Consultation Booking System</p>
        </div>
    </footer>
    <script src="assets/app.js"></script>
    </body>
    </html>
    <?php
}

