<?php

namespace App\Controller;

use App\Entity\Ordonnance;
use App\Form\OrdonnanceType;
use App\Repository\OrdonnanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/ordonnance')]
class OrdonnanceController extends AbstractController
{
    #[Route('/', name: 'app_ordonnance_index', methods: ['GET'])]
    public function index(OrdonnanceRepository $ordonnanceRepository): Response
    {
        return $this->render('ordonnance/index.html.twig', [
            'ordonnances' => $ordonnanceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ordonnance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ordonnance = new Ordonnance();
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ordonnance);
            $entityManager->flush();

            return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ordonnance/new.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ordonnance_show', methods: ['GET'])]
    public function show(Ordonnance $ordonnance): Response
    {
        return $this->render('ordonnance/show.html.twig', [
            'ordonnance' => $ordonnance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ordonnance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ordonnance $ordonnance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ordonnance/edit.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ordonnance_delete', methods: ['POST'])]
    public function delete(Request $request, Ordonnance $ordonnance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ordonnance->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ordonnance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/pdf/{id}', name: 'app_ordonnance_pdf_show')]
    public function pdfShow(Ordonnance $ordonnance): Response 
    {
        // Création des options de Dompdf pour autoriser le chargement d'images externes
        $options = new Options();
        $options->set('isRemoteEnabled', true);  
    
        // Création de l'instance Dompdf avec les options configurées
        $dompdf = new Dompdf($options);
    
        // Rendu du template Twig avec les données de la ordonnance
        $html = $this->renderView('ordonnance/pdf.html.twig', [
            'ordonnance' => $ordonnance
        ]);
    
        // Chargement du HTML dans Dompdf
        $dompdf->loadHtml($html);
    
        // Définition du format de papier
        $dompdf->setPaper('A4', 'portrait');
    
        // Rendu du PDF
        $dompdf->render();
    
        // Retour de la réponse HTTP avec le contenu PDF
        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $ordonnance->getPatient() . '.pdf"',
            ]
        );
    }
}
