<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($to, $subject, $message)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'seuemail@gmail.com';
        $mail->Password   = 'suasenha';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('seuemail@gmail.com', 'Seu Nome');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();

        return true;

    } catch (Exception $e) {
        return $mail->ErrorInfo;
    }
}

//Como usar:
//helper('mail');
//sendEmail('teste@gmail.com', 'Assunto', '<b>Mensagem HTML</b>');