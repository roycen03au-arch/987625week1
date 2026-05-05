<?php
declare(strict_types=1);

function renderHeader(string $title, string $activePage): void
{
    $pages = [
        "index" => ["label" => "Home", "url" => "index.php"],
        "about" => ["label" => "About", "url" => "about.php"],
        "register-student" => ["label" => "Register", "url" => "register_student.php"],
        "book" => ["label" => "Book Consultation", "url" => "book_consultation.php"],
        "view" => ["label" => "Booking", "url" => "view_bookings.php"],
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
            <a href="index.php" class="brand">LOGO</a>
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
            <div class="footer-grid">
                <section>
                    <h3>Location</h3>
                    <p></p>
                </section>
                <section>
                    <h3>Around the Web</h3>
                    <div class="social-list" aria-label="Social media links">
                        <a href="#" aria-label="Facebook">F</a>
                        <a href="#" aria-label="Twitter">T</a>
                        <a href="#" aria-label="LinkedIn">L</a>
                        <a href="#" aria-label="Dribbble">D</a>
                    </div>
                </section>
                <section>
                    <h3>About Booking</h3>
                    <p>Book lecturer consultation sessions and manage bookings in one place.</p>
                </section>
            </div>
        </div>
    </footer>
    <script src="assets/app.js"></script>
    </body>
    </html>
    <?php
}

