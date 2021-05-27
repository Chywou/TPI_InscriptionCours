<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use App\Form\ForgotPasswordType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class MailerController extends AbstractController
{
    public function __construct(MailerInterface $mailer, UserRepository $user)
    {
        $this->mailer  = $mailer;
        $this->user = $user;
    }

    public function sendEmail(User $user)
    {
        $random = random_bytes(10);
        $email = (new Email())
            ->from('support@courscyno.com')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Mot de passe perdu')
            ->text('')
            ->html('<p>Votre nouveau mot de passe :</p>' . $random);

        $this->mailer->send($email);
    }

    
    /**
     * @Route("/forgotPassword", name="forgot_password")
     */
    public function forgotPassword(Request $request): Response
    {
        $random = rtrim( base64_encode(random_bytes(16)), '=');
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $userForgot = $this->user->findOneBy(['email' => $form->getData('email')]);
            $this->sendEmail($userForgot);
        }
        return $this->render('security/forgot_password.html.twig',['form' => $form->createView(), 'random' => $random]);
        
    }
}
