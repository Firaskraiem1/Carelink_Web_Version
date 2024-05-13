<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\CategorieProdRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]

    public function base(CategorieProdRepository $categorieProdRepository, SessionInterface $session): Response
    {
        $cat_prod = $categorieProdRepository->findAll();
        $session->set('cat_prod', $cat_prod);
        return $this->render('base.html.twig', [
            //'categorie_prods' => $categorieProdRepository->findAll(),

        ]);
    }
}
