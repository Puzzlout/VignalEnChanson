<?php
include_once 'config.php';
require 'phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$return_message = '';
$error = false;
// Check for empty fields
if (empty($_POST[REQUEST_NAME]) ||
    empty($_POST[REQUEST_EMAIL]) ||
    empty($_POST[REQUEST_PHONE]) ||
    empty($_POST[REQUEST_MESSAGE]) ||
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
) {
    $return_message = "No arguments Provided!";
    $error = true;
}
$captcha_response = $_POST['g-recaptcha-response'];
$mail_content_vars = [
    "[[".REQUEST_NAME."]]" => strip_tags(htmlspecialchars($_POST[REQUEST_NAME])),
    "[[".REQUEST_EMAIL."]]" => strip_tags(htmlspecialchars($_POST[REQUEST_EMAIL])),
    "[[".REQUEST_PHONE."]]" => strip_tags(htmlspecialchars($_POST[REQUEST_PHONE])),
    "[[".REQUEST_MESSAGE."]]" => strip_tags(htmlspecialchars($_POST[REQUEST_MESSAGE]))
];

$captcha_check = json_decode(
    file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?hl=fr&secret=" . $recaptcha_secret
        . "&response=" . $captcha_response
        . "&remoteip=" . $_SERVER['REMOTE_ADDR']
    ), true);
if ($captcha_check['success'] == false) {
    $error = true;
    $return_message = $recaptcha_error_msg;
} else {
    $mail->isSMTP();
    $mail->isHTML(true);
    $mail->SMTPDebug = 0;
    $mail->Host = $mail_host;
    $mail->SMTPAuth = $mail_smtpauth;
    $mail->AuthType = $mail_authtype;
    $mail->Username = $mail_username;
    $mail->Password = $mail_password;
    $mail->SMTPSecure = $mail_smtpsecure;
    $mail->Port = $mail_port;
    $mail->CharSet = $mail_charset;

    $mail->setLanguage($mail_lang);
    $mail->setFrom($mail_from);
    $mail->addAddress($mail_to);
    $mail->Subject = strtr($mail_subject, $mail_content_vars);
    $mail->Body = strtr($mail_body, $mail_content_vars);
    $mail->AltBody = strtr($mail_alt_body, $mail_content_vars);
    if (!$mail->send()) {
        $error = true;
        $return_message = $mail_error;
    } else {
        $return_message = $mail_success;
    }

}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode(array('success' => !$error, 'message' => $return_message));
?>
