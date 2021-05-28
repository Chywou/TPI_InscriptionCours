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
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailerController extends AbstractController
{
    public function __construct(ManagerRegistry $om, MailerInterface $mailer, UserRepository $user)
    {
        $this->om  = $om;
        $this->mailer  = $mailer;
        $this->user = $user;
    }

    public function sendEmail(User $user, $random)
    { 

        $email = (new TemplatedEmail())
            ->from('support@courscyno.com')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Mot de passe perdu')
            ->htmlTemplate('emails/new_password.html.twig')
            ->context(['user' => $user, 'random' => $random])
            
            ;

        $this->mailer->send($email);
    }


    
    /**
     * @Route("/forgotPassword", name="forgot_password")
     */
    public function forgotPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $patern = "/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W+_])/";
            $isValide = false;
            
            do
            {
                $random = substr(base64_encode(random_bytes(12)), 0, -2);
    
                if(strlen($random) >= 12 and preg_match($patern, $random))
                {
                    $isValide = true;
                }
            } while(!$isValide);


            $userForgot = $this->user->findOneBy(['email' => $form->getData('email')]);

            $userForgot->setPassword($passwordEncoder->encodePassword($userForgot, $random));

            $this->om->getManager()->persist($userForgot);
            $this->om->getManager()->flush();
            
            
            $this->sendEmail($userForgot, $random);

            return $this->render('security/mail_send.html.twig',['form' => $form->createView()]);
        }
        return $this->render('security/forgot_password.html.twig',['form' => $form->createView()]);
        
    }
}
