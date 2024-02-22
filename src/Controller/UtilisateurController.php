<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UtilisateurController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('base.html.twig',[
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/utilisateur/list', name: 'utilisateur_all')]
    public function getAllUsers(UtilisateurRepository $userRepo): Response
    {
        $users = $userRepo->findAll();
        return $this->render('utilisateur/list.html.twig',[
            'users' => $users,
        ]);
    }

    #[Route('/utilisateur/get/{id}', name: 'utilisateur_getOne')]
    public function getUserById($id,UtilisateurRepository $userRepo): Response
    {
        $user = $userRepo->find($id);
        if ($user == null) {
            throw $this->createNotFoundException('Ce utilisateur n\'existe pas');
        }
        return $this->render('utilisateur/user.html.twig',[
            'user' => $user,
        ]);
    }

    #[Route('/utilisateur/add', name: 'app_add_utilisateur')]
    public function addUser(Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passwordHasher,SessionInterface $session): Response
    {
        $entitymanager = $managerRegistry->getManager();
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setMotDePasse($hashedPassword);
            $entitymanager->persist($user);
            $entitymanager->flush();
            $session->set('user',$user);
            return $this->redirectToRoute('app_home');
        }
        return $this->renderForm('Utilisateur/newUser.html.twig',[
            'form'=>$form,
        ]);
    }

    #[Route('/utilisateur/update/{id}', name: 'utilisateur_update')]
    public function updateUser($id,ManagerRegistry $managerRegistry, UtilisateurRepository $userRepo,Request $request): Response
    {
        $em = $managerRegistry->getManager();
        $user = $userRepo->find($id);
        $form = $this->createForm(UtilisateurType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("utilisateur_update", ['id' => $user->getId()]);
        }
        return $this->renderForm('utilisateur/profile.html.twig',[
            'form' => $form,
        ]);
    }

    #[Route('/utilisateur/delete/{id}', name: 'utilisateur_delete')]
    public function deleteUser($id, ManagerRegistry $managerRegistry, UtilisateurRepository $userRepo,Request $request): Response
    {
        $em = $managerRegistry->getManager();
        $user = $userRepo->find($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('utilisateur_all');
    }
}
