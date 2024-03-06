<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;



#[Route('/produit')]
class ProduitController extends AbstractController
{

    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('base.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }
    #[Route('/listeProduits', name: 'app_produit_liste', methods: ['GET'])]
    public function indexListe(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/ListeProduits.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/admin', name: 'app_produit_ad_index', methods: ['GET'])]
    public function indexad(ProduitRepository $produitRepository): Response
    {
        return $this->render('admin/dashboard__tables.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }
 
    
    #[Route('/admin/new', name: 'app_produit_new_admin')]
    public function newDash(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
               
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form['image']->getData();

        
            if ($imageFile) {
                
                $newFilename = md5(uniqid()).'.'.$imageFile->guessExtension();
               
                $imageFile->move(
                    $this->getParameter('imageDir'), 
                    $newFilename
                );
                
                $produit->setImage($newFilename);
            }
            $entityManager->persist($produit);
            $entityManager->flush();
    
    
            return $this->redirectToRoute('app_produit_ad_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('admin/dashboard__new__prod.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }



    #[Route('/admin/{id}', name: 'app_produit_show_admin', methods: ['GET'])]
    public function showDash(Produit $produit): Response
    {
        return $this->render('admin/dashboard__show__prod.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_produit_edit_admin', methods: ['GET', 'POST'])]
    public function editDash(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_ad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/dashboard__update__prod.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

   

    #[Route('/admin/{id}', name: 'app_produit_delete_admin', methods: ['POST'])]
    public function deleteDash(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        
            $entityManager->remove($produit);
            $entityManager->flush();
        

        return $this->redirectToRoute('app_produit_ad_index', [], Response::HTTP_SEE_OTHER);
    }
    


    #[Route('/search', name: 'app_prod_search', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        $repository = $this->entityManager->getRepository(ProduitType::class);
        $query = $repository->createQueryBuilder('p');
    
        if($request->query->get('query')) {
            $query->andWhere('p.nom_prod LIKE :query')
                ->setParameter('query', "%{$request->query->get('query')}%");
    
            $query->orWhere('p.prix_prod = :prix_prod')
                ->setParameter('query', $request->query->get('query'));
                
                
        
            // ... add other fields to search
                
    
            // ... add other fields to search
    
            $produits = $query->getQuery()->getResult();
    
            // Si les résultats sont vides, retournez une réponse vide pour éviter les erreurs côté client
            if (empty($produits)) {
                return new JsonResponse([]);
            }
    
            // Convertissez les objets produi$produit en un tableau associatif pour éviter les problèmes de sérialisation
            $formattedproduits = [];
            foreach ($produits as $produit) {
                $formattedproduits[] = [
                    'id' => $produit->getIdProd(),
                    'nom' => $produit->getNomProd(),
                    'prix' => $produit->getPrixProd(),
                    // Ajoutez d'autres champs si nécessaire
                ];
            }
    
            return new JsonResponse($formattedproduits);
        }
    
        // Si aucune requête n'est effectuée, retournez une réponse vide
        return new JsonResponse([]);
    }
}
