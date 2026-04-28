<?php
declare(strict_types=1);
require_once __DIR__ . "/includes/layout.php";
renderHeader("Contact", "contact");
?>
<section class="card">
    <h2>Contact</h2>
    <p>Maintainer: ICT312 Student Project Team</p>
    <p>Email: consultation-support@example.com</p>
    <p>Office Hours: Monday to Friday, 9:00 AM - 5:00 PM</p>
</section>

<section class="card">
    <h3>Send a Message (Demo only)</h3>
    <form>
        <label for="name">Name</label>
        <input id="name" name="name" type="text" placeholder="Your name">
        <label for="message">Message</label>
        <textarea id="message" name="message" placeholder="Write your message"></textarea>
        <button type="button" onclick="alert('Demo form only in version 1.')">Submit</button>
    </form>
</section>
<?php renderFooter(); ?>

