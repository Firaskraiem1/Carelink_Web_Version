<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig',[
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/utilisateur/get/{id}', name: 'app_utilisateur')]
    public function getUserById($id): Response
    {
        return $this->render('utilisateur/index.html.twig',[
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/utilisateur/add', name: 'app_add_utilisateur')]
    public function addUser(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $entitymanager = $managerRegistry->getManager();
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entitymanager->persist($user);
            $entitymanager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->renderForm('Utilisateur/newUser.html.twig',[
            'form'=>$form,
        ]);
    }

    #[Route('/utilisateur/add', name: 'app_utilisateur')]
    public function updateUser(): Response
    {
        return $this->render('utilisateur/index.html.twig',[
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/utilisateur/add', name: 'app_utilisateur')]
    public function deleteUser(): Response
    {
        return $this->render('utilisateur/index.html.twig',[
            'controller_name' => 'UserController',
        ]);
    }
}
