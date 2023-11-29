<?php
/*
namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(
        $to = 'wederni05@gmail.com',
        $content = '<p>See Twig integration for better HTML integration!</p>',
        $subject='Time for Symfony Mailer!'
    ): void
    {
        $email = (new Email())
            ->from('iyed.ouederni@esprit.tn')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
           // ->text('Sending emails is fun again!')
            ->html($content);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $transportException) {
            // Get the response code from the exception
            $responseCode = $transportException->getResponseCode();
            dump($responseCode);
        }

        // ...
    }

}*/