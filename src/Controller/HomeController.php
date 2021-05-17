<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(ManagerRegistry $oms)
    {
        $this->om  = $oms;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('pages/home.html.twig');
    }
}