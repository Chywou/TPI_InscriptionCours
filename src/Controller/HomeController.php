<?php

namespace App\Controller;

use App\Repository\LessonRepository;
use Doctrine\Persistence\ManagerRegistry ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function index(): Response
    {
        $allLessons = $this->lesson->findOrderByDate();
        return $this->render('pages/home.html.twig', ['allLessons' => $allLessons]);
    }
}