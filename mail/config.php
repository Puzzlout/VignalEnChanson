<?php
define("REQUEST_NAME", "name");
define("REQUEST_EMAIL", "email");
define("REQUEST_PHONE", "phone");
define("REQUEST_MESSAGE", "message");

$recaptcha_secret = "****";
$recaptcha_error_msg = "Le reCaptcha n'est pas valide.";

$mail_host = '****';
$mail_smtpauth = true;
$mail_authtype = 'LOGIN';
$mail_username = '****';
$mail_password = '****';
$mail_smtpsecure = 'tls';
$mail_port = 587;
$mail_charset = 'UTF8';
$mail_lang = "fr";

$mail_from = 'from';
$mail_to = 'to';

$mail_subject = "Message envoyé depuis le site bernardvignal.fr par [[name]]";
$mail_body =
    "Bonjour,<br/><br/>Vous avez reçu un nouveau message du site bernardvignal.fr.<br/><br/>" .
    "Voici les détails :<br/><br/>" .
    "Nom: [[name]]<br/>Courrier électronique : [[email]]<br/>" .
    "Téléphone : [[phone]]<br/>" .
    "Message :<br/>[[message]]<br/><br/>".
    "<i>Envoyé depuis le site bernardvignal.fr</i>";
$mail_alt_body =
    "Bonjour,\n\nVous avez reçu un nouveau message du site bernardvignal.fr.\n\n" .
    "Voici les détails :\n\nNom: [[name]]".
    "\n\nCourrier électronique : [[email]]".
    "\n\nTéléphone : [[phone]]\n\n".
    "Message :\n[[message]]\n\n" .
    "Envoyé depuis le site bernardvignal.fr";
$mail_success = "Le message a été envoyé.";
$mail_error = "Le message n'a pas été envoyé.";
