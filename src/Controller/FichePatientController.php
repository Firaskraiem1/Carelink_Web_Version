<?php

namespace App\Controller;

use App\Entity\FichePatient;
use App\Entity\Patient;
use App\Form\FichePatientType;
use App\Repository\FichePatientRepository;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/fiche/patient')]
class FichePatientController extends AbstractController
{
    #[Route('/', name: 'app_fiche_patient_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('fiche_patient/index.html.twig');
    }

    #[Route('/list', name: 'app_fiche_patient_listes', methods: ['GET'])]
    public function list(FichePatientRepository $fichePatientRepository): Response
    {
        return $this->render('fiche_patient/listes.html.twig', [
            // 'patientFiche' => 'false',
            'fiche_patients' => $fichePatientRepository->findAll(),
        ]);
    }

    //------------------------Patient--------------------


    #[Route('/list/{idPatient}', name: 'app_fiche_list_patient', methods: ['GET'])]
    public function listFichesPatient(FichePatientRepository $fichePatientRepository, EntityManagerInterface $entityManager, $idPatient): Response
    {
        $patient = $entityManager->getRepository(Patient::class)->find($idPatient);
        $fiche_patients = $fichePatientRepository->findBy(['relationPatient' => $patient]);
        return $this->render('patient/listes_fiches.html.twig', [
            'idPatient' => $idPatient,
            'fiche_patients' => $fiche_patients,
        ]);
    }
    #[Route('/{id}/{idPatient}/show', name: 'app_fiche_show_patient', methods: ['GET'])]
    public function showFichePatient(FichePatient $fichePatient, $idPatient): Response
    {
        return $this->render('patient/showFiche.html.twig', [
            'id' => $idPatient,
            'fiche_patient' => $fichePatient,
        ]);
    }

    //------------------end------------------------


    #[Route('/new', name: 'app_fiche_patient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FlashyNotifier $flashy, EntityManagerInterface $entityManager): Response
    {
        $fichePatient = new FichePatient();
        $form = $this->createForm(FichePatientType::class, $fichePatient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fichePatient);
            $entityManager->flush();
            $flashy->success('Fiche Patient creé avec succes');
            return $this->redirectToRoute('app_fiche_patient_listes', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fiche_patient/new.html.twig', [
            'fiche_patient' => $fichePatient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fiche_patient_show', methods: ['GET'])]
    public function show(FichePatient $fichePatient): Response
    {
        return $this->render('fiche_patient/show.html.twig', [
            'fiche_patient' => $fichePatient,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_fiche_patient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, FichePatientRepository $rep): Response
    {
        $fichePatient = $rep->find($id);
        $form = $this->createForm(FichePatientType::class, $fichePatient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fichePatient);
            $entityManager->flush();
            return $this->redirectToRoute('app_fiche_patient_listes');
        }
        return $this->render('fiche_patient/edit.html.twig', [
            'fiche_patient' => $fichePatient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fiche_patient_delete', methods: ['POST'])]
    public function delete(EntityManagerInterface $entityManager, FichePatientRepository $rep, $id): Response
    {
        $fichePatient = $rep->find($id);
        $entityManager->remove($fichePatient);
        $entityManager->flush();
        return $this->redirectToRoute('app_fiche_patient_index', [], Response::HTTP_SEE_OTHER);
    }




    #------------------------------------ADMIN-------------------------------------------#

    #----------------admin index----------------
    #[Route('/admin', name: 'app_fiche_patient_listes_admin', methods: ['GET'])]
    public function indexAdmin(FichePatientRepository $fichePatientRepository): Response
    {
        return $this->render('admin_fiche/dashboard__tables.html.twig', [
            'fiche_patients' => $fichePatientRepository->findAll(),
        ]);
    }
    #----------------end----------------

    #----------------admin show fiche----------------
    #[Route('/admin/{id}', name: 'app_fiche_patient_show_admin', methods: ['GET'])]
    public function showficheadmin(FichePatient $fichePatient): Response
    {
        return $this->render('admin_fiche/dashboard__show__fiche.html.twig', [
            'fiche_patient' => $fichePatient,
        ]);
    }
    #----------------end----------------

    #----------------admin new fiche----------------
    #[Route('/admin/fiche/new', name: 'app_fiche_patient_new_admin', methods: ['GET', 'POST'])]
    public function newFicheAdmin(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fichePatient = new FichePatient();
        $form = $this->createForm(FichePatientType::class, $fichePatient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fichePatient);
            $entityManager->flush();

            return $this->redirectToRoute('app_fiche_patient_listes_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_fiche/dashboard__new_fiche.html.twig', [
            'fiche_patient' => $fichePatient,
            'form' => $form,
        ]);
    }

    #----------------end----------------

    #----------------admin edit fiche----------------
    #[Route('/admin/{id}/edit', name: 'app_fiche_patient_edit_admin', methods: ['GET', 'POST'])]
    public function editFiche(Request $request, EntityManagerInterface $entityManager, int $id, FichePatientRepository $rep): Response
    {
        $fichePatient = $rep->find($id);
        $form = $this->createForm(FichePatientType::class, $fichePatient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fichePatient);
            $entityManager->flush();
            return $this->redirectToRoute('app_fiche_patient_listes_admin');
        }
        return $this->render('admin_fiche/dashboard__update__fiche.html.twig', [
            'fiche_patient' => $fichePatient,
            'form' => $form,
        ]);
    }
    #----------------end----------------

    #----------------admin delete fiche ----------------
    #[Route('/admin/{id}', name: 'app_fiche_patient_delete_admin', methods: ['POST'])]
    public function deleteFiche(EntityManagerInterface $entityManager, FichePatientRepository $rep, $id): Response
    {
        $fichePatient = $rep->find($id);
        $entityManager->remove($fichePatient);
        $entityManager->flush();
        return $this->redirectToRoute('app_fiche_patient_listes_admin', [], Response::HTTP_SEE_OTHER);
    }
    #----------------end----------------
}
