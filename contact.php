<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

$error = false;
$submitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['email'];
    $no_reply = getenv('NO_REPLY_EMAIL');
    $support = getenv('SUPPORT_EMAIL');

    $mail = new PHPMailer(true);

    $mail->isSMTP();

    $mail->Mailer = 'smtp';
    $mail->Host = getenv('SMTP_SERVER');
    $mail->Username = getenv('SMTP_USERNAME');
    $mail->Password = getenv('SMTP_PASSWORD');
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Port = 587;

    $mail->From = $no_reply;

    $mail->addAddress($support);
    $mail->addReplyTo($user);

    $mail->Subject = "Feedback from $user";
    $mail->Body = $_POST['body'];

    try {
        $mail->send();
        $submitted = true;
    } catch (Exception $ex) {
        $error = true;
    }

    if (!$error) {
        // tell user that feedback has been submitted
        $mail->clearAddresses();
        $mail->clearReplyTos();

        $mail->addAddress($user);

        $mail->isHTML();

        $mail->Subject = 'Thank you for your feedback';
        $mail->Body = file_get_contents('email.htm', true);

        try {
            $mail->send();
        } catch (Exception $ex) {
            //
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php require_once "templates/head.template.php" ?>
</head>

<body>
    <?php include "templates/navbar.template.php"; ?>

    <div class="my-5 container">
        <h1 class="mb-4">Contact us</h1>

        <p>
            Provide feedback by filling out the form below.
            <br>
            You can also contact us directly: <a href="mailto:support@freedomwall.me">support@freedomwall.me</a>
        </p>

        <form class="needs-validation" action="/contact" method="post" novalidate>
            <?php if ($error) : ?>
                <div class="alert alert-danger alert-dismissible fade show form-outline mb-4">
                    Oops, that didn't go through. Try contacting us directly, or try again later.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($submitted) : ?>
                <div class="alert alert-success alert-dismissible fade show form-outline mb-4">
                    Success! Your feedback has been submitted.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <div class="form-outline mb-3">
                <label class="form-label" for="data">Email</label>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="body">Content</label>
                <textarea name="body" class="form-control" required style="min-height: 10em;"></textarea>
            </div>

            <input type="submit" class="btn btn-success" value="Send">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="/scripts/validateform.js"></script>
</body>

</html>