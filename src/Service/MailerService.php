<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerService
{

    public function __construct(private MailerInterface $mailer)
    {
    }
    public function sendEmail($content): void
    {
        $email = (new Email())
            ->from('tanwichette@gmail.com')
            ->to('tanwichette@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Reclamation')

            ->html($content);

        $this->mailer->send($email);

        // ...
    }
}
