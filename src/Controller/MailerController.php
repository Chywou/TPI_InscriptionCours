<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MailerController extends AbstractController
{
    public function __construct(ManagerRegistry $om, MailerInterface $mailer, UserRepository $user)
    {
        $this->om  = $om;
        $this->mailer  = $mailer;
        $this->user = $user;
    }

    /**
     * Envoi automatique de mail
     */
    public function sendEmail(User $user, $random, $template, $name)
    { 

        $email = (new TemplatedEmail())
            ->from('support@courscyno.com')
            ->to($user->getEmail())
            ->subject($name)
            ->htmlTemplate($template)
            ->context(['user' => $user, 'random' => $random])
            ;

        $this->mailer->send($email);
    }

    /**
     * Génère automatiquement un mot de passe respectant la politique de mot de passse
     */
    public function generatePassword()
    {
        // Paterne respectant la polotique de mot de passe
        $patern = "/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W+_])/";
        $isValide = false;
        
        do
        {
            // Génère une chaîne de caractère aléatoire
            $random = substr(base64_encode(random_bytes(12)), 0, -2);

            // Vérifie si le mot de passe respecte la politique de mot de passe
            if(strlen($random) >= 12 and preg_match($patern, $random))
            {
                $isValide = true;
            }
        } while(!$isValide);

        return $random;

    }

    
    /**
     * Page du mot de passe perdu
     * @Route("/motDePasseOublie", name="forgot_password")
     */
    public function forgotPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Récupère l'utilisateur indiqué
            $userForgot = $this->user->findOneBy(['email' => $form->getData('email')]);

            // Vérifie que l'utilisateur existe dans la BD
            if(!empty($userForgot))
            {
                $random = $this->generatePassword();

                $userForgot->setPassword($passwordEncoder->encodePassword($userForgot, $random));

                $this->om->getManager()->persist($userForgot);
                $this->om->getManager()->flush();
                
                
                $this->sendEmail($userForgot, $random, 'emails/new_password.html.twig', 'Mot de passe oublié');
            }

            return $this->render('security/mail_send.html.twig',['form' => $form->createView()]);
        }
        return $this->render('security/forgot_password.html.twig',['form' => $form->createView()]);
        
    }

    /**
     * Gestion de l'envoi du mot de passe lors de la création d'un admin
     * @IsGranted("ROLE_ADMIN")
     * @Route("/createPassword{email}", name="create_password")
     */
    public function createPassword($email, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $newUser = $this->user->findOneBy(['email' => $email]);

        // Vérifie qu'il s'agisse bien d'un nouvel utilisateur
        if (is_null($newUser->getPassword()))
        {

            $random = $this->generatePassword();

            $newUser->setPassword($passwordEncoder->encodePassword($newUser, $random));

            $this->om->getManager()->persist($newUser);
            $this->om->getManager()->flush();
            $this->sendEmail($newUser, $random, 'emails/create_password.html.twig', 'Création d\'un compte');
            
        }
        return $this->redirectToRoute('admin_management');
    }
}
