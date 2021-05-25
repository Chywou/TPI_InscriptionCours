<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Category;
use App\Entity\User;
use App\Form\ModifyAdminType;
use App\Form\AddLessonType;
use App\Form\AddCategoryType;
use App\Form\AddManagerType;
use App\Form\ModifyPasswordType;
use App\Repository\LessonRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
* Demande le rôle admin pour l'accès de ce contrôler
*
* @IsGranted("ROLE_ADMIN")
*/
class AdminController extends AbstractController
{

    public function __construct(ManagerRegistry $om, LessonRepository $lesson, CategoryRepository $category, UserRepository $user)
    {
        $this->om  = $om;
        $this->lesson = $lesson;
        $this->category = $category;
        $this->user = $user;
    }

    /**
     * @Route("/admin/home", name="admin_home")
     */
    public function index(): Response
    {
        $allLessons = $this->lesson->findOrderByDate();
        $allCategories = $this->category->findAll();
        $allManagers = $this->user->findAll();
        return $this->render('admin/admin.html.twig', ['allLessons' => $allLessons, 'allCategories' => $allCategories, 'allManagers' => $allManagers]);
    }

    /**
     * @Route("/admin/addLesson", name="admin_add_lesson")
     */
    public function addLesson(Request $request): Response
    {
        $newLesson = new Lesson();
        $form = $this->createForm(AddLessonType::class, $newLesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->om->getManager()->persist($newLesson);
            $this->om->getManager()->flush();
            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/add_lesson.html.twig',['form' => $form->createView()]);
    }

    
    /**
     * @Route("/admin/addCategory", name="admin_add_category")
     */
    public function addCategory(Request $request): Response
    {
        $newCategory = new Category();
        $form = $this->createForm(AddCategoryType::class, $newCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->om->getManager()->persist($newCategory);
            $this->om->getManager()->flush();
            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/add_category.html.twig',['form' => $form->createView()]);
    }
    
    /**
     * @Route("/admin/addmanager", name="admin_add_manager")
     */
    public function addManager(Request $request): Response
    {
        $newManager = new User();
        $form = $this->createForm(AddManagerType::class, $newManager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $newManager->setRoles(["ROLE_MANAGER"]);
            $this->om->getManager()->persist($newManager);
            $this->om->getManager()->flush();
            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/add_manager.html.twig',['form' => $form->createView()]);
    }

    /**
     * @Route("/admin/profil", name="modify_admin")
     */
    public function modifyAdmin(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ModifyAdminType::class, $user);
        $form->handleRequest($request);

        $formPassword = $this->createForm(ModifyPasswordType::class);
        $formPassword->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->om->getManager()->persist($user);
            $this->om->getManager()->flush();
            $this->addFlash('success', 'Modification d\'informations effectuées');
        }

        if ($formPassword->isSubmitted() && $formPassword->isValid())
        {
            // Encodage du mot de passe
            $user->setPassword($passwordEncoder->encodePassword($user, $formPassword->get('plainPassword')->getData()));

            $this->om->getManager()->persist($user);
            $this->om->getManager()->flush();
            $this->addFlash('success', 'Mot de passe modifié');
        }
        return $this->render('admin/modify_admin.html.twig',['form' => $form->createView(), 'formPassword' => $formPassword->createView()]);
    }
}
