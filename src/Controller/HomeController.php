<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
<<<<<<< HEAD
=======
use App\Repository\CategorieProdRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
>>>>>>> gestion_produit

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
<<<<<<< HEAD
    public function base(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'HomeController',
=======
    public function base(CategorieProdRepository $categorieProdRepository , SessionInterface $session ): Response
    {   $cat_prod = $categorieProdRepository->findAll();
        $session->set('cat_prod',$cat_prod);
        return $this->render('base.html.twig',[
            //'categorie_prods' => $categorieProdRepository->findAll(),
>>>>>>> gestion_produit
        ]);
    }
}
