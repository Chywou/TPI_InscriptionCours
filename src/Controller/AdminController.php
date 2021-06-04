<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Category;
use App\Entity\User;
use App\Form\ModifyAdminType;
use App\Form\AddLessonType;
use App\Form\AddCategoryType;
use App\Form\AddManagerType;
use App\Form\AddAdminType;
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
use Knp\Component\Pager\PaginatorInterface;

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
     * Page de gestion des cours
     * @Route("/admin/cours", name="admin_home")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $datas = $this->lesson->findOrderByDate();

         // Détecte si le nombre passé dans le get est pertinant pour la pagination (plus grand que 0 et si c'est un chiffre)
        if($request->query->get('page') <= 0 || null !== $request->query->get('page') && !is_numeric($request->query->get('page')))
        {
            $allLessons = $paginator->paginate($datas, 1, 5);
        }
        else
        {
            $allLessons = $paginator->paginate($datas, $request->query->getInt('page', 1), 5);
        }
        
        $allCategories = $this->category->findAll();
        $allManagers = $this->user->findAll();

        return $this->render('admin/admin.html.twig', ['allLessons' => $allLessons, 'allCategories' => $allCategories, 'allManagers' => $allManagers]);
    }

    /**
     * Page d'ajout de cours
     * @Route("/admin/ajoutCours", name="admin_add_lesson")
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
            $this->addFlash('success', 'Vous avez correctement ajouté le cours '. $newLesson->getCategory()->getName() . ' du ' . $newLesson->getDateLesson()->format('d.m.Y'). ' de ' . $newLesson->getStartHour()->format('H:i') . ' à ' . $newLesson->getEndHour()->format('H:i'));
            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/add_lesson.html.twig',['form' => $form->createView()]);
    }

    
    /**
     * Page d'ajout d'une catégorie
     * @Route("/admin/ajoutCategorie", name="admin_add_category")
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
            $this->addFlash('success', 'Vous avez ajouté la catégorie ' . $newCategory->getName() . '.');
            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/add_category.html.twig',['form' => $form->createView()]);
    }
    
    /**
     * Page d'ajout de responsable
     * @Route("/admin/ajoutResponsable", name="admin_add_manager")
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
            $this->addFlash('success', 'Vous avez ajouté le responsable ' . $newManager->getFirstName() . ' ' . $newManager->getLastName() .'.');
            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/add_manager.html.twig',['form' => $form->createView()]);
    }

    /**
     * Page de modification de son profil
     * @Route("/admin/profil", name="modify_admin")
     */
    public function modifyAdmin(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();

        // Formulaire de modification des informations personnelles
        $form = $this->createForm(ModifyAdminType::class, $user);
        $form->handleRequest($request);

        // Formulaire de modification du mot de passe
        $formPassword = $this->createForm(ModifyPasswordType::class);
        $formPassword->handleRequest($request);

        // Vérification pour les modification des informations personnelles
        if ($form->isSubmitted() && $form->isValid())
        {
            // Vérifie que l'adresse mail n'est pas déjà présente dans la BD
            if(is_null($this->user->findOneBy(['email' => $user->getEmail()])) || $user->getId() == $this->user->findOneBy(['email' => $user->getEmail()])->getId())
            {
                $this->om->getManager()->persist($user);
                $this->om->getManager()->flush();
                $this->addFlash('success', 'Modification d\'informations effectuées');
            }
            else
            {
                $this->addFlash('danger', 'Un administrateur avec l\'adresse mail  ' . $user->getEmail() . ' existe déjà.');
            }
            
        }

        // Vérification pour la modification du mot de passe
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

    /**
     * Page d'ajout d'administrateur
     * @Route("/admin/ajoutAdmin", name="admin_add_admin")
     */
    public function addAdmin(Request $request): Response
    {
        $newAdmin = new User();
        $form = $this->createForm(AddAdminType::class, $newAdmin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if(is_null($this->user->findOneBy(['email' => $newAdmin->getEmail()])))
            {
                $newAdmin->setRoles(["ROLE_ADMIN"]);
                $this->om->getManager()->persist($newAdmin);
                $this->om->getManager()->flush();   
                $this->addFlash('success', 'Vous avez créé l\'administrateur ' . $newAdmin->getFirstName() . ' ' . $newAdmin->getLastName());

                // Envoi du mail contenant le mot de passe
                return $this->redirectToRoute('create_password', ['email' => $newAdmin->getEmail()]);
            }
            $this->addFlash('danger', 'Un administrateur avec l\'adresse mail  ' . $newAdmin->getEmail() . ' existe déjà.');
        }
        return $this->render('admin/add_admin.html.twig',['form' => $form->createView()]);
    }

    /**
     * Page de la gestion des administrateurs
     * @Route("/admin/adminGestion", name="admin_management")
     */
    public function adminManagement(): Response
    {
        $allAdmins = $this->user->findByRoles('ROLE_ADMIN');
        return $this->render('admin/admin_management.html.twig', ['allAdmins' => $allAdmins]);
    }
}
