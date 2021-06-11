<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegisterLessonType;
use App\Repository\LessonRepository;
use App\Repository\ParticipantRepository;
use Doctrine\Persistence\ManagerRegistry ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    public function __construct(ManagerRegistry $om, LessonRepository $lesson, ParticipantRepository $participant)
    {
        $this->om  = $om;
        $this->lesson = $lesson;
        $this->participant = $participant;
    }

    /**
     * Page d'accueil
     * @Route("/", name="home")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $datas = $this->lesson->findVisibleOrderByDate();

        // Détecte si le nombre passé dans le get est pertinant pour la pagination (plus grand que 0 et si c'est un chiffre)
        if($request->query->get('page') <= 0 || null !== $request->query->get('page') && !is_numeric($request->query->get('page')))
        {
            $allLessons = $paginator->paginate($datas, 1, 5);
        }
        else
        {
            $allLessons = $paginator->paginate($datas, $request->query->getInt('page', 1), 5);
        }

        return $this->render('pages/home.html.twig', ['allLessons' => $allLessons]);
    }

    /**
     * Page d'inscription à chaque cours
     * @Route("/inscription:{id}", name="register")
     */
    public function registerLesson($id, Request $request): Response
    {

        $lesson = $this->lesson->find($id);
        $newParticipant = new Participant();
        $form = $this->createForm(RegisterLessonType::class, $newParticipant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if(is_null($this->participant->findOneBy(['firstName' => $newParticipant->getFirstName(), 'lastName' => $newParticipant->getLastName(), 'dogName' => $newParticipant->getDogName(), 'lesson' => $lesson])))
            {
                $newParticipant->setLesson($lesson);
                $this->om->getManager()->persist($newParticipant);
                $this->om->getManager()->flush();
                $this->addFlash('success', 'Vous êtes inscrit au cours '. $lesson->getCategory()->getName() . ' du ' . $lesson->getDateLesson()->format('d.m.Y'). ' de ' . $lesson->getStartHour()->format('H:i') . ' à ' . $lesson->getEndHour()->format('H:i'));
                return $this->redirectToRoute('home');
            }
            $this->addFlash('danger', 'Cet utilisateur et son chien sont déjà inscrit à ce cours');
        }
        return $this->render('pages/register.html.twig',['lesson' => $lesson, 'form' => $form->createView()]);
    }
}