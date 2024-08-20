<?php
namespace Lib\SMTP;
use Lib\SMTP\PHPMailer;
use Lib\SMTP\Exception;
use App\Config;

class Mailer {
    private $config;
    public function SendMail($target, $title, $html){
        $Config = new Config();
        $this->config = $Config->config;
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = $this->config['SMTP']['Host'];
        $mail->SMTPSecure = "ssl";
        $mail->Port = $this->config['SMTP']['Port'];
        $mail->CharSet = "UTF-8";
        $mail->FromName = $this->config['SMTP']['Nickname'];
        $mail->Username = $this->config['SMTP']['Username'];
        $mail->Password = $this->config['SMTP']['Password'];
        $mail->From = $this->config['SMTP']['Email'];
        $mail->isHTML(true);
        $mail->addAddress($target);
        $mail->Subject = $title;
        $mail->Body = $html;
        $status = $mail->send();
    }
}
