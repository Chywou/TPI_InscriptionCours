<?php

namespace App\Controller;

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
        $allLessons = $paginator->paginate($datas, $request->query->getInt('page', 1), 3);
        return $this->render('pages/home.html.twig', ['allLessons' => $allLessons]);
    }
}