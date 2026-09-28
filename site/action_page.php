<?php
$bSnow = false;
require_once 'config.php';

function h($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function posted($name)
{
    return trim((string)($_POST[$name] ?? ''));
}

$isPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
$errors = [];
$sent = false;
$name = '';
$email = '';
$phone = '';
$subject = '';
$message = '';
$mailtoHref = 'mailto:' . EMAIL_TO;

if ($isPost) {
    $name = posted('name');
    $email = posted('email');
    $phone = posted('phone');
    $subject = posted('subject');
    $message = posted('message');
    $honeypot = posted('website');

    if ($honeypot !== '') {
        // Quietly accept bot submissions without sending anything.
        $sent = true;
    } else {
        if ($name === '') {
            $errors[] = 'Please add your name.';
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please add a valid email address.';
        }
        if ($message === '') {
            $errors[] = 'Please add a message.';
        }

        if (!$errors) {
            $safeName = trim(preg_replace('/[\r\n]+/', ' ', $name));
            $safeEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
            $cleanSubject = trim(preg_replace('/[\r\n]+/', ' ', $subject));
            if ($cleanSubject === '') {
                $cleanSubject = 'Website enquiry from ' . $safeName;
            }

            $bodyLines = [
                'Name: ' . $name,
                'Email: ' . $email,
            ];
            if ($phone !== '') {
                $bodyLines[] = 'Phone: ' . $phone;
            }
            $bodyLines[] = '';
            $bodyLines[] = 'Message:';
            $bodyLines[] = $message;
            $body = implode("\n", $bodyLines);

            $headers = [
                'From: Real Father Xmas website <' . EMAIL_TO . '>',
                'Reply-To: ' . $safeEmail,
                'Content-Type: text/plain; charset=UTF-8',
            ];

            $sent = mail(EMAIL_TO, $cleanSubject, $body, implode("\r\n", $headers));
            $mailtoHref = 'mailto:' . EMAIL_TO
                . '?subject=' . rawurlencode($cleanSubject)
                . '&body=' . rawurlencode($body);
        }
    }
}

require_once 'header.php';
?>
<div class="main contactResult">
    <h2>Contact Form</h2>

    <?php if (!$isPost) { ?>
        <p>Please use the form on the home page to send a message to the elves.</p>
        <p><a class="buttonLink" href="/#contact">Go to the contact form</a></p>
    <?php } elseif ($sent) { ?>
        <p>Thank you for your message. The elves will get back to you as soon as possible.</p>
        <p><a class="buttonLink" href="/">Back to the home page</a></p>
    <?php } else { ?>
        <?php if ($errors) { ?>
            <div class="formNotice formNotice--error">
                <p>Please check the form:</p>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?php echo h($error); ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } else { ?>
            <div class="formNotice formNotice--error">
                <p>Sorry, the form could not send your message just now.</p>
            </div>
        <?php } ?>

        <p>You can still email the elves directly:</p>
        <p><a class="buttonLink" href="<?php echo h($mailtoHref); ?>">Open an email instead</a></p>
        <p><a href="/#contact">Back to the contact form</a></p>
    <?php } ?>
</div>
<?php
require_once 'footer.php';
?>
