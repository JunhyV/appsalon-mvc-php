<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    } 
    public function enviarConfirmacion(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p>Hola <strong>' . $this->nombre .'</strong> Has creado tu cuenta en App Salon, solo debes confirmarla presionando en el siguiente enlace:</p>';
        $contenido .= '<a href="' . $_ENV['APP_URL'] .'/confirmar-cuenta?token=' . $this->token .'">Confirmar cuenta</a>';
        $contenido .= '<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje.</p>';
        $contenido.= '</hml>';


        $mail->Body    = $contenido;
        $mail->send();
    }
    public function enviarRecuperacion(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p>Hola <strong>' . $this->nombre .'</strong> Para reestablecer la contraseña de tu cuenta en App Salon, solo debes ingresar al siguiente enlace:</p>';
        $contenido .= '<a href="' . $_ENV['APP_URL'] .'/recuperar?token=' . $this->token .'">Reestablecer contraseña</a>';
        $contenido .= '<p>Si tu no olvidaste tu contraseña, puedes ignorar el mensaje.</p>';
        $contenido.= '</hml>';


        $mail->Body    = $contenido;
        $mail->send();
    }
}