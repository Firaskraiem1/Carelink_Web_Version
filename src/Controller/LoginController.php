<?php

namespace App\Controller;

use App\Form\LoginFormType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function indexAdmin(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            
        ]);
    }

    #[Route('/patient', name: 'app_patient')]
    public function indexPatient(): Response
    {
        return $this->render('patient/dashboard.html.twig', [
            
        ]);
    }


    #[Route('/login', name: 'app_login')]
    public function index(Request $request,UtilisateurRepository $userRepo, UserPasswordHasherInterface $passwordHasher, SessionInterface $session): Response
    {
        $form = $this->createForm(LoginFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();
            $user = $userRepo->findOneBy(["email"=>$email]);
            if($user && $passwordHasher->isPasswordValid($user, $password)){
                $session->set('user',$user);
                if($user->getRole() == "ROLE_ADMIN"){
                    return $this->redirectToRoute('app_admin');
                }
                if($user->getRole() == "ROLE_PATIENT"){
                    return $this->redirectToRoute('app_patient');
                }
                if($user->getRole() == "ROLE_MEDECIN"){
                    return $this->redirectToRoute('app_medecin');
                }
                return $this->redirectToRoute('app_home');
            }else{
                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
