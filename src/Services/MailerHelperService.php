<?php


namespace App\Services;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Class MailerHelperService
 * @package App\Services
 */
class MailerHelperService
{
    private $mailer;

    /**
     * MailerHelperService constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $reciever
     * @param string $joke
     * @param string $category
     * @throws TransportExceptionInterface
     */
    public function sendMail(string $reciever, string $joke, string $category)
    {

        $email = (new TemplatedEmail())
            ->from('mailtrap@example.com')
            ->to($reciever)
            ->subject("Randomize Joke from $category ")
            // path to your Twig template
            ->htmlTemplate('email.html.twig')
            ->context([
                'joke' => $joke,
                'category' => $category
            ]);
        $this->mailer->send($email);
    }

}