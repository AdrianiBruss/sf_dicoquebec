<?php



namespace AppBundle\Service;



class MailService {

    private $mailer;
    public function __construct($mailer){
        $this->mailer=$mailer;
    }

    public function sendMailOnRemoval($email,$term){
        $message = $this->mailer->createMessage()
            ->setSubject('Reset Password')
            ->setFrom($email)
            ->setTo('abrussolo@gmail.com')
            ->setBody(
                $this->renderView(
                    'mail/term_removed.html.twig',
                    array('user' => $term)
                ),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
    public function sendMailOnAdd($email,$term){
        $message = $this->mailer->createMessage()
            ->setSubject('Reset Password')
            ->setFrom($email)
            ->setTo('abrussolo@gmail.com')
            ->setBody(
                $this->renderView(
                    'mail/term_added.html.twig',
                    array('user' => $term)
                ),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
    public function sendMailOnUpdate($email,$term){
        $message = $this->mailer->createMessage()
            ->setSubject('Reset Password')
            ->setFrom($email)
            ->setTo('abrussolo@gmail.com')
            ->setBody(
                $this->renderView(
                    'mail/term_updated.html.twig',
                    array('user' => $term)
                ),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
}