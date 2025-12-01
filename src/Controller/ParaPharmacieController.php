<?php

namespace App\Controller;

use App\Entity\ParaPharmacie;
use App\Form\ParaPharmacieType;
use App\Repository\ParaPharmacieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\SearchFormType; 
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('/para/pharmacie')]
class ParaPharmacieController extends AbstractController
{
    #[Route('/', name: 'app_para_pharmacie_index', methods: ['GET'])]
    public function index(ParaPharmacieRepository $paraPharmacieRepository): Response
    {
        return $this->render('para_pharmacie/parapharmacie.html.twig', [
            'para_pharmacies' => $paraPharmacieRepository->findAll(),
        ]);
    }

    #[Route('/espacePara', name: 'app_para_pharmacie_espace_index', methods: ['GET'])]
    public function indexespace(ParaPharmacieRepository $paraPharmacieRepository): Response
    {
        return $this->render('para_pharmacie/espace.html.twig', [
            'para_pharmacies' => $paraPharmacieRepository->findAll(),
        ]);
    }
    #[Route('/admin', name: 'app_para_pharmacie_ad_index', methods: ['GET'])]
    public function indexad(ParaPharmacieRepository $paraPharmacieRepository): Response
    {
        return $this->render('admin/dashboard__tables.html.twig', [
            'para_pharmacies' => $paraPharmacieRepository->findAll(),
        ]);
    }
    #[Route('/adminfront', name: 'app_para_pharmacie_ad_front_index', methods: ['GET'])]
    public function indexadfront(ParaPharmacieRepository $paraPharmacieRepository): Response
    {
      return $this->render('admin/accueil.html.twig', [
        'para_pharmacies' => $paraPharmacieRepository->findAll(),
    ]);
    }
    

    #[Route('/new', name: 'app_para_pharmacie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager)
{
  $paraPharmacie = new ParaPharmacie();

  $form = $this->createForm(ParaPharmacieType::class, $paraPharmacie);
  $form->handleRequest($request);

  if ($form->isSubmitted() && $form->isValid()) {

    $file = $form->get('imageFile')->getData();

    if($file) {

      $fileName = md5(uniqid()) . '.' . $file->guessExtension();

      $file->move(
        $this->getParameter('images'),
        $fileName  
      );

      $paraPharmacie->setImageFile($file);
      $paraPharmacie->setImageName($fileName);

    } else {
      // handle no file case
    }

    $entityManager->persist($paraPharmacie);
    $entityManager->flush();

    return $this->redirectToRoute('app_para_pharmacie_index');

  }

  return $this->render('para_pharmacie/new.html.twig', [
    'paraPharmacie' => $paraPharmacie,
    'form' => $form->createView()
  ]);
}
#[Route('/admin/new', name: 'app_para_pharmacie_ad_new', methods: ['GET', 'POST'])]
public function newDash(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
{
    $paraPharmacie = new ParaPharmacie();

    $form = $this->createForm(ParaPharmacieType::class, $paraPharmacie);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $file = $form->get('imageFile')->getData();

        if ($file) {
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
                $this->getParameter('images'),
                $fileName
            );

            $paraPharmacie->setImageFile($file);
            $paraPharmacie->setImageName($fileName);
        }

        $entityManager->persist($paraPharmacie);
        $entityManager->flush();

        return $this->redirectToRoute('app_para_pharmacie_ad_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('admin/dashboard__new__para.html.twig', [
        'form' => $form->createView(),
        'paraPharmacie' => $paraPharmacie
    ]);
}

      

    #[Route('/{id}', name: 'app_para_pharmacie_show', methods: ['GET'])]
    public function show(ParaPharmacie $paraPharmacie): Response
    {
        return $this->render('para_pharmacie/show.html.twig', [
            'para_pharmacie' => $paraPharmacie,
        ]);
    }

    #[Route('admin/{id}', name: 'app_para_pharmacie_ad_show', methods: ['GET'])]
    public function showad(ParaPharmacie $paraPharmacie): Response
    {
        return $this->render('admin/dashboard__show__para.html.twig', [
            'para_pharmacie' => $paraPharmacie,
        ]);
    }
    #[Route('adminfront/{id}', name: 'app_para_pharmacie_ad_front_show', methods: ['GET'])]
    public function showadfront(ParaPharmacie $paraPharmacie): Response
    {
      return $this->render('admin/info.html.twig', [
        'para_pharmacie' => $paraPharmacie,
    ]);
    }

    #[Route('/{id}/edit', name: 'app_para_pharmacie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ParaPharmacie $paraPharmacie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParaPharmacieType::class, $paraPharmacie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageFile')->getData();

    if($file) {

      $fileName = md5(uniqid()) . '.' . $file->guessExtension();

      $file->move(
        $this->getParameter('images'),
        $fileName  
      );

      $paraPharmacie->setImageFile($file);
      $paraPharmacie->setImageName($fileName);

    } else {
      // handle no file case
    }
            $entityManager->flush();

            return $this->redirectToRoute('app_para_pharmacie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('para_pharmacie/edit.html.twig', [
            'para_pharmacie' => $paraPharmacie,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_para_pharmacie_ad_edit', methods: ['GET', 'POST'])]
    public function editDash(Request $request, ParaPharmacie $paraPharmacie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParaPharmacieType::class, $paraPharmacie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageFile')->getData();

    if($file) {

      $fileName = md5(uniqid()) . '.' . $file->guessExtension();

      $file->move(
        $this->getParameter('images'),
        $fileName  
      );

      $paraPharmacie->setImageFile($file);
      $paraPharmacie->setImageName($fileName);

    } else {
      // handle no file case
    }
            $entityManager->flush();

            return $this->redirectToRoute('app_para_pharmacie_ad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/dashboard__update__para.html.twig', [
            'para_pharmacie' => $paraPharmacie,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_para_pharmacie_delete', methods: ['POST'])]
    public function delete(Request $request, ParaPharmacie $paraPharmacie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paraPharmacie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($paraPharmacie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_para_pharmacie_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('admin/{id}', name: 'app_para_pharmacie_ad_delete', methods: ['POST'])]
    public function deleteAd(Request $request, ParaPharmacie $paraPharmacie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paraPharmacie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($paraPharmacie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_para_pharmacie_ad_index', [], Response::HTTP_SEE_OTHER);
    }
    
    
 
    #[Route('/order/{field}/{direction}', name: 'app_para_order')] 
    public function order(ParaPharmacieRepository $repo, $field, $direction)
    {
      return $this->render('para_pharmacie/index.html.twig', [
       'para_pharmacies' => $repo->findByOrder($field, $direction)
      ]);
    }
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
      $this->entityManager = $entityManager;
    }
    #[Route('/search', name: 'app_para_search', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        $repository = $this->entityManager->getRepository(ParaPharmacie::class);
        $query = $repository->createQueryBuilder('p');
    
        if($request->query->get('query')) {
            $query->andWhere('p.nomPara LIKE :query')
                ->setParameter('query', "%{$request->query->get('query')}%");
    
            $query->orWhere('p.email LIKE :query')
                ->setParameter('query', "%{$request->query->get('query')}%");
               
            $query->orWhere('p.nbrPharmaciens = :nbrPharmaciens')
                ->setParameter('nbrPharmaciens', $request->query->get('query'));
                
        
            // ... add other fields to search
                
    
            // ... add other fields to search
    
            $paraPharmacies = $query->getQuery()->getResult();
    
            // Si les résultats sont vides, retournez une réponse vide pour éviter les erreurs côté client
            if (empty($paraPharmacies)) {
                return new JsonResponse([]);
            }
    
            // Convertissez les objets ParaPharmacie en un tableau associatif pour éviter les problèmes de sérialisation
            $formattedParaPharmacies = [];
            foreach ($paraPharmacies as $paraPharmacie) {
                $formattedParaPharmacies[] = [
                    'id' => $paraPharmacie->getId(),
                    'nomPara' => $paraPharmacie->getNomPara(),
                    'email' => $paraPharmacie->getEmail(),
                    'nbrPharmaciens' => $paraPharmacie->getNbrPharmaciens(),
                    // Ajoutez d'autres champs si nécessaire
                ];
            }
    
            return new JsonResponse($formattedParaPharmacies);
        }
    
        // Si aucune requête n'est effectuée, retournez une réponse vide
        return new JsonResponse([]);
    }
    private function getErrorList($errors) {

      $list = [];
  
      foreach($errors as $error) {
        $list[] = $error->getMessage();
      }
  
      return $list;
  
    }
   



    
}
