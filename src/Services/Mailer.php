<?php

namespace Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host     = $_ENV['MAIL_HOST'] ?? 'maildev';
        $this->mailer->Port     = (int)($_ENV['MAIL_PORT'] ?? 1025);
        $this->mailer->SMTPAuth = false;
        $this->mailer->CharSet  = 'UTF-8';
        $this->mailer->setFrom(
            $_ENV['MAIL_FROM']      ?? 'no-reply@ecoride.fr',
            $_ENV['MAIL_FROM_NAME'] ?? 'Covoiturage2026'
        );
    }

    public function sendConfirmation(string $toMail, string $toName, string $token): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($toMail, $toName);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Confirmez votre inscription – Covoiturage2026';

            $confirmUrl = ($_ENV['APP_URL'] ?? 'http://localhost:8085') . '/auth/confirm?token=' . $token;

            ob_start();
            require dirname(__DIR__) . '/Views/emails/confirmation.php';
            $this->mailer->Body = ob_get_clean();

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log('Mailer Error: ' . $e->getMessage());
            return false;
        }
    }
}