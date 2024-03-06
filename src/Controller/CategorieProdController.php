<?php

namespace App\Controller;

use App\Entity\CategorieProd;
use App\Form\CategorieProdType;
use App\Repository\CategorieProdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categorie/prod')]
class CategorieProdController extends AbstractController
{
   /* #[Route('/', name: 'app_categorie_prod_index', methods: ['GET'])]
    public function index(CategorieProdRepository $categorieProdRepository): Response
    {
        return $this->render('categorie_prod/index.html.twig', [
            'categorie_prods' => $categorieProdRepository->findAll(),
        ]);
    }*/

    #[Route('/admin', name: 'app_categorie_prod_index_admin', methods: ['GET'])]
    public function indexad(CategorieProdRepository $categorieProdRepository): Response
    {
        return $this->render('adminCat/dashboard__tables.html.twig', [
            'categorie_prods' => $categorieProdRepository->findAll(),
        ]);
    }

   

    #[Route('/new/admin', name: 'app_categorie_prod_new_admin', methods: ['GET', 'POST'])]
    public function newad(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieProd = new CategorieProd();
        $form = $this->createForm(CategorieProdType::class, $categorieProd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorieProd);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_prod_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('adminCat/dashboard__new__prod.html.twig', [
            'categorie_prod' => $categorieProd,
            'form' => $form,
        ]);
    }

   

    #[Route('/{id}/admin', name: 'app_categorie_prod_show_admin', methods: ['GET'])]
    public function showad(CategorieProd $categorieProd): Response
    {
        return $this->render('adminCat/dashboard__show__prod.html.twig', [
            'categorie_prod' => $categorieProd,
        ]);
    }

    

    #[Route('/{id}/edit/admin', name: 'app_categorie_prod_edit_admin', methods: ['GET', 'POST'])]
    public function editad(Request $request, CategorieProd $categorieProd, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieProdType::class, $categorieProd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_prod_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('adminCat/dashboard__update__prod.html.twig', [
            'categorie_prod' => $categorieProd,
            'form' => $form,
        ]);
    }

    

    #[Route('/{id}/admin', name: 'app_categorie_prod_delete_admin', methods: ['POST'])]
    public function deletead(Request $request, CategorieProd $categorieProd, EntityManagerInterface $entityManager): Response
    {
        
            $entityManager->remove($categorieProd);
            $entityManager->flush();
       

        return $this->redirectToRoute('app_categorie_prod_index_admin', [], Response::HTTP_SEE_OTHER);
    }
    
}
