<?php

namespace App\Controller;



use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;




use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/utilisateur/admin/update/{id}', name: 'admin_utilisateur_update')]
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
        return $this->renderForm('admin/updateUser.html.twig',[
            'form' => $form,
        ]);
    }

    #[Route('/admin/bloque/{id}', name: 'app_bloque_user')]
    public function bloquer($id,UtilisateurRepository $userRepo, ManagerRegistry $managerRegistry): Response
    {
        $em = $managerRegistry->getManager();
        $user=$userRepo->find($id);
        $user->setActive(false);
        $em->flush();
        return $this->redirectToRoute('utilisateur_all');
    }

    #[Route('/admin/debloque/{id}', name: 'app_debloque_user')]
    public function debloquer($id,UtilisateurRepository $userRepo, ManagerRegistry $managerRegistry): Response
    {
        $em = $managerRegistry->getManager();
        $user=$userRepo->find($id);
        $user->setActive(true);
        $em->flush();
        return $this->redirectToRoute('utilisateur_all');
    }
}
