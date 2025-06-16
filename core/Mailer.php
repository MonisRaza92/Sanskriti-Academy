<?php
require_once __DIR__ . '/../vendor/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../vendor/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->setup();
    }

    private function setup() {
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.hostinger.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'support@sanslritiacademy.org';
        $this->mail->Password = 'Sanslriti@01';
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port = 465;

        $this->mail->setFrom('support@sanslritiacademy.org', 'Sanskriti Academy');
        $this->mail->isHTML(true);
    }

    public function send($to, $subject, $body) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            return $this->mail->send();
        } catch (Exception $e) {
            error_log('Mailer Error: ' . $this->mail->ErrorInfo . ' Exception: ' . $e->getMessage());
            return false;
        }
    }
    public function sendOtp($email, $otp)
    {
        $subject = "Your OTP Code";
        $message = "Your OTP code is: " . $otp;
        $headers = "From: no-reply@sanskriti.com\r\n";
        // Use mail() or your preferred mailing library
        mail($email, $subject, $message, $headers);
    }
}