<?php

namespace App\Manager;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailManager
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function registerEmail($user)
    {
        $email = (new TemplatedEmail())
            ->from('admin@gmail.com')
            ->to($user->getEmail())
            ->subject('Account Verification Email')
            ->htmlTemplate('email/registeremail.html.twig')
            ->context([
                'user' => $user
            ]);

        $this->mailer->send($email);
    }
    public function forgotPasswordEmail($user)
    {
        $email = (new TemplatedEmail())
            ->from('admin@gmail.com')
            ->to($user->getEmail())
            ->subject('Forgot password Email')
            ->htmlTemplate('email/forgotpasswordemail.html.twig')
            ->context([
                'user' => $user
            ]);

        $this->mailer->send($email);
    }

}