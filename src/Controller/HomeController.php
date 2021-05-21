<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegisterLessonType;
use App\Repository\LessonRepository;
use Doctrine\Persistence\ManagerRegistry ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    public function __construct(ManagerRegistry $om, LessonRepository $lesson)
    {
        $this->om  = $om;
        $this->lesson = $lesson;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $datas = $this->lesson->findOrderByDate();
        $allLessons = $paginator->paginate($datas, $request->query->getInt('page', 1), 5);
        return $this->render('pages/home.html.twig', ['allLessons' => $allLessons]);
    }

    /**
     * @Route("/register:{id}", name="register")
     */
    public function registerLesson($id, Request $request): Response
    {

        $lesson = $this->lesson->find($id);
        $newParticipant = new Participant();
        $form = $this->createForm(RegisterLessonType::class, $newParticipant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $newParticipant->setLesson($lesson);
            $this->om->getManager()->persist($newParticipant);
            $this->om->getManager()->flush();
            $this->addFlash('success', 'Vous êtes inscrit au cours '. $lesson->getCategory()->getName() . ' du ' . $lesson->getDateLesson()->format('d.m.Y'). ' de ' . $lesson->getStartHour()->format('H:i') . ' à ' . $lesson->getEndHour()->format('H:i'));
            return $this->redirectToRoute('home');
        }
        return $this->render('pages/register.html.twig',['lesson' => $lesson, 'form' => $form->createView()]);
    }
}