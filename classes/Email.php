<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $name;
    public $token;
    
    public function __construct($email, $name, $token)
    {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendConfirmation() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('supportengineeringr@dotask.com');
        $mail->addAddress($this->email, $this->name);
        $mail->Subject = 'Account Confirmation';
        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        $contain = '<html>';
        $contain .= "<p><strong>Hi " . $this->name .  "</strong> You have Successfully Registered your account in ToDo List App; but you need to confirm it.</p>";
        $contain .= "<p>Click here: <a href='" . $_ENV['HOST'] . "/confirm-account?token=" . $this->token . "'>Confirm Account</a>";       
        $contain .= "<p>If you did not create this account; you can ignore the message</p>";
        $contain .= '</html>';
        $mail->Body = $contain;
        //Enviar el mail
        $mail->send();

    }

    public function sendInstructions() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('supportengineeringr@dotask.com');
        $mail->addAddress($this->email, $this->name);
        $mail->Subject = 'Restore Password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hi " . $this->name .  "</strong> You have requested to reset your password, follow the link below to do.</p>";
        $contenido .= "<p>Click here: <a href='" . $_ENV['HOST'] . "/restore-password?token=" . $this->token . "'>Restore Password</a>";        
        $contenido .= "<p>If you did not create this account; you can ignore the message</p>";
        $contenido .= '</html>';
        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();
    }
}