<?php
if (isset($_POST['submit'])) {

    $recipient_email = 'skapp@email.com';
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $headers = 'From: ' . $_POST['email'];

    ini_set('SMTP', $smtp_host);
    ini_set('smtp_port', $smtp_port);
    ini_set('sendmail_from', $recipient_email);
    ini_set('sendmail_path', "/usr/sbin/sendmail -t -i");

    if (mail($recipient_email, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}
