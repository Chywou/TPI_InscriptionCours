<?php

namespace App\Controller;

use App\Repository\LessonRepository;
use Doctrine\Persistence\ManagerRegistry ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* Demande le role admin pour tout l'accès de ce contrôler
*
* @IsGranted("ROLE_ADMIN")
*/
class AdminController extends AbstractController
{

    public function __construct(ManagerRegistry $om, LessonRepository $lesson)
    {
        $this->om  = $om;
        $this->lesson = $lesson;
    }

    /**
     * @Route("/admin/home", name="admin_home")
     */
    public function index(): Response
    {
        $allLessons = $this->lesson->findOrderByDate();
        return $this->render('admin/admin.html.twig', ['allLessons' => $allLessons]);
    }
}