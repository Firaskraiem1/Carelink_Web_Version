<?php

namespace App\Controller;

use App\Entity\CategoryEvenement;
use App\Form\CategorieEvenementType;
use App\Repository\CategoryEvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categorie')]
class CategorieEvenementController extends AbstractController
{
    #[Route('/', name: 'app_categorie_evenement_index', methods: ['GET'])]
    public function index(CategoryEvenementRepository $categorieEvenementRepository): Response
    {
        return $this->render('categorie_evenement/index.html.twig', [
            'categorie_evenements' => $categorieEvenementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categorie_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieEvenement = new CategoryEvenement();
        $form = $this->createForm(CategorieEvenementType::class, $categorieEvenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorieEvenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_evenement/new.html.twig', [
            'categorie_evenement' => $categorieEvenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_evenement_show', methods: ['GET'])]
    public function show(CategoryEvenement $categorieEvenement): Response
    {
        return $this->render('categorie_evenement/show.html.twig', [
            'categorie_evenement' => $categorieEvenement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoryEvenement $categorieEvenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieEvenementType::class, $categorieEvenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_evenement/edit.html.twig', [
            'categorie_evenement' => $categorieEvenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, CategoryEvenement $categorieEvenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieEvenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorieEvenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
}
