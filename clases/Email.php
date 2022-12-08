<?php
namespace Clases;

use PHPMailer\PHPMailer\PHPMailer;



class Email{
  
  public  $email;
  public  $nombre;
  public  $token;

  public function __construct($email, $nombre, $token){

    $this->email = $email;
    $this->nombre = $nombre;
    $this->token = $token;
  }
  public function enviarConfirmacion(){
    
    $phpmailer = new PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = '14b1b28a0649cf';
    $phpmailer->Password = '7e284fba3d16e2';

    $phpmailer->setFrom('cuentas@appsalon.com');
    $phpmailer->addAddress('cuentas@appsalon.com', 'appsalon.com');
    $phpmailer->Subject = 'Confirma tu cuenta';


    $phpmailer->isHTML(true);
    $phpmailer->CharSet = 'utf8';

    $contenido = "<html>";
    $contenido .= "<p><strong>Hola " .$this->nombre . " </strong>Has creado tu cuenta de app salon confirma presionando el siguiente enlace</p>";
    $contenido.= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token ."'>Confirmar
        cuenta</a></p>";
    $contenido .= "<p>Si tu no solicitaste esta cuenta puedes ignorar el mensaje</p>";
    $contenido .= "</html>";

    $phpmailer->Body = $contenido;

    $phpmailer->send();


  }

  public function enviarInstrucciones(){
    $phpmailer = new PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = '14b1b28a0649cf';
    $phpmailer->Password = '7e284fba3d16e2';

    $phpmailer->setFrom('cuentas@appsalon.com');
    $phpmailer->addAddress('cuentas@appsalon.com', 'appsalon.com');
    $phpmailer->Subject = 'Reestablece tu password';


    $phpmailer->isHTML(true);
    $phpmailer->CharSet = 'utf8';

    $contenido = "<html>";
    $contenido .= "<p><strong>Hola " .$this->nombre . " </strong>Has Solicitado reestablecer tu password</p>";
    $contenido.= "<p>Presiona aqui: <a href='http://localhost:3000/recuperar?token=" . $this->token ."'>Restablecer tu constraseña</a></p>";
    $contenido .= "<p>Si tu no solicitaste esta cuenta puedes ignorar el mensaje</p>";
    $contenido .= "

    </html>";

    $phpmailer->Body = $contenido;

    $phpmailer->send();
  }
}