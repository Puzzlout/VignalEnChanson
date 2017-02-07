<?php
require 'phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$return_message = '';
$error = false;
// Check for empty fields
if (empty($_POST['name']) ||
    empty($_POST['email']) ||
    empty($_POST['phone']) ||
    empty($_POST['message']) ||
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
) {
    $return_message = "No arguments Provided!";
    $error = true;
}
$captcha_response = $_POST['g-recaptcha-response'];
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));

$secret = "6LdRWRMUAAAAANwL7tMT9qcexAVfFXRPpNje2F2n";
$captcha_check = json_decode(
    file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret=".$secret ."&response=" .$captcha_response."&remoteip=".$_SERVER['REMOTE_ADDR']
    ), true);
if($captcha_check['success'] == false) {
    $error = true;
    $return_message = "reCaptcha n'est pas valide.";
} else {
    $mail->isSMTP();
    $mail->isHTML(true);
    $mail->SMTPDebug = 0;
    $mail->Host = 'ssl0.ovh.net';
    $mail->SMTPAuth = true;
    $mail->AuthType = 'LOGIN';
    $mail->Username = 'contact@bernardvignal.fr';
    $mail->Password = 'bernard%2017';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->CharSet = 'UTF8';

    $mail->setLanguage('fr');
    $mail->setFrom('contact@bernardvignal.fr');
    $mail->addAddress('contact@bernardvignal.fr');
    $mail->Subject = "Message envoyé depuis le site bernardvignal.fr par $name";
    $mail->Body = "Bonjour,<br/><br/>Vous avez reçu un nouveau message du site bernardvignal.fr.<br/><br/>" .
        "Voici les détails :<br/><br/>Nom: $name<br/><br/>Courrier électronique : $email_address<br/><br/>Téléphone : $phone<br/><br/>Message :<br/>$message";
    $mail->AltBody = "Bonjour,\n\nVous avez reçu un nouveau message du site bernardvignal.fr.\n\n" .
        "Voici les détails :\n\nNom: $name\n\nCourrier électronique : $email_address\n\nTéléphone : $phone\n\nMessage :\n$message";
    if(!$mail->send()) {
        $error = true;
        $return_message = "Le message n'a pas été envoyé.";
    } else {
        $return_message = "Le message a été envoyé.";
    }

}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode(array('success'=>!$error, 'message' => $return_message));
?>
