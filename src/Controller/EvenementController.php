<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    //Affichage historique
    #[Route('/historique', name: 'app_evenement_historique_index', methods: ['GET'])]
    public function historique(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/historique.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    //Dashboard 
    #[Route('/dashboard', name: 'app_evenement_dashboard_index', methods: ['GET'])]
    public function indexDashboard(EvenementRepository $evenementRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setStatus('en attente');
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    //afffihcer détail dans l'historique
    #[Route('/historique/{id}', name: 'app_evenement_details', methods: ['GET'])]
    public function showDetail(Evenement $evenement): Response
    {
        return $this->render('evenement/details.html.twig', [
            'evenement' => $evenement,
        ]);
    }



    //dashboard
    #[Route('/dashboard/{id}', name: 'app_evenement_dashboard_show', methods: ['GET'])]
    public function showDashboard(Evenement $evenement): Response
    {
        return $this->render('admin/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/historique/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setStatus('en attente');
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_historique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    //dashboard
    #[Route('/dashboard/{id}/edit', name: 'app_evenement_dashboard_edit', methods: ['GET', 'POST'])]
    public function editDashboard(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setStatus('en attente');
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_dashboard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_historique_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/dashboard/{id}', name: 'app_evenement_dashboard_delete', methods: ['POST'])]
    public function deleteDashboard(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_dashboard_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/approve/{id}', name: 'app_evenement_approve', methods: ['GET'])]
    public function approve(Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $evenement->setStatus('approved');
        $entityManager->flush();

        return $this->redirectToRoute('app_evenement_dashboard_index');
    }

    #[Route('/reject/{id}', name: 'app_evenement_reject', methods: ['GET'])]
    public function reject(Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $evenement->setStatus('rejected');
        $entityManager->flush();

        return $this->redirectToRoute('app_evenement_dashboard_index');
    }

}
