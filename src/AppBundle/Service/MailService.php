<?php



namespace AppBundle\Service;



class MailService {

    private $mailer;
    private $templating;
    public function __construct($mailer,$templating){
        $this->mailer=$mailer;
        $this->templating=$templating;
    }

    public function sendMailOnRemoval($email,$term){
        $message = $this->mailer->createMessage()
            ->setSubject('Dikkebek : terme supprimé')
            ->setFrom($email)
            ->setBody(
                $this->templating->render(
                    'mail/term_removed.html.twig',
                    array(
                        'term' => $term,
                        'email' => $email
                    )
                ),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
    public function sendMailOnAdd($email,$term){
        $message = $this->mailer->createMessage()
            ->setSubject('Dikkebek : terme ajouté')
            ->setFrom($email)
            ->setBody(
                $this->templating->render(
                    'mail/term_added.html.twig',
                    array(
                        'term' => $term,
                        'email' => $email
                    )
                ),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
    public function sendMailOnUpdate($email,$term){
        $message = $this->mailer->createMessage()
            ->setSubject('Dikkebek : terme modifié')
            ->setFrom($email)
            ->setBody(
                $this->templating->render(
                    'mail/term_updated.html.twig',
                    array(
                        'term' => $term,
                        'email' => $email
                    )
                ),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
}