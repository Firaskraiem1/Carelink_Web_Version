<?php

namespace App\Controller;

use App\Entity\Med;
use App\Entity\Patient;
use App\Entity\ReservationRdv;
use App\Form\ReservatioRdvType;
use App\Form\SearchType;
use App\Model\SearchMedecin;
use App\Repository\MedRepository;
use App\Repository\PatientRepository;
use App\Repository\ReservationRdvRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reservation')]
class ReservationRdvController extends AbstractController
{
    // #[Route('/rdv', name: 'app_reservation_rdv')]
    // public function index(): Response
    // {
    //     return $this->render('reservation_rdv/index.html.twig', [
    //         'controller_name' => 'ReservationRdvController',
    //     ]);
    // }
    #[Route('/{id}/search', name: 'app_reservation_search')]
    public function serachMedecin(Request $request, MedRepository $repMedecins, PaginatorInterface $paginatorInterface, int $id): Response
    {
        $serachMedecin = new SearchMedecin();
        $form = $this->createForm(SearchType::class, $serachMedecin);
        $form->handleRequest($request);
        $pagination = $paginatorInterface->paginate(
            $repMedecins->paginationQuery(),
            $request->query->get('page', 1),
            6
        );
        if ($form->isSubmitted() && $form->isValid()) {
            dd($serachMedecin);
        }
        return $this->render('reservation_rdv/index.html.twig', [
            'idPatient' => $id,
            'controller_name' => 'ReservationRdvController',
            'form' => $form,
            'pagination' => $pagination,
        ]);
    }


    #[Route('/list/{id}', name: 'app_reservation_listes_patient', methods: ['GET'])]
    public function listRdvPatient(ReservationRdvRepository $reservationRdvRepository, int $id): Response
    {
        $listesrdvs = $reservationRdvRepository->findBy(['patient' => $id]);
        $rdvs = [];
        foreach ($listesrdvs as $rdv) {
            $rdvs[] = [

                'id' => $rdv->getId(),
                'start' => $rdv->getDateRdv()->format('Y-m-d H:i:s'),
                'end' => $rdv->getDateRdv()->format('Y-m-d H:i:s'),
                'title' => ' Rdv: ' . $rdv->getMotif(),
                'description' => '',
                'backgroundColor' => '#99c93d',
                'borderColor' => '#99c93d',
                'textColor' => 'white',
                'allDay' => true,

            ];
        }
        $data = json_encode($rdvs);
        return $this->render('reservation_rdv/listesPatient.html.twig', [
            'data' => $data,
            'idPatient' => $id,
            'listesrdvs' => $listesrdvs,
        ]);
    }
    #[Route('/{idPatient}/{id}/show', name: 'app_reservation_show', methods: ['GET'])]
    public function show(ReservationRdvRepository $reservationRdvRepository, int $idPatient, int $id): Response
    {
        $rdv = $reservationRdvRepository->findBy(['patient' => $idPatient, 'id' => $id]);
        return $this->render('reservation_rdv/show.html.twig', [
            'id' => $id,
            'idPatient' => $idPatient,
            'rdvs' => $rdv,
        ]);
    }

    #[Route('/{idMedecin}/{idPatient}/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $idPatient, int $idMedecin,): Response
    {
        $patient = $entityManager->getRepository(Patient::class)->find($idPatient);
        $medecin = $entityManager->getRepository(Med::class)->find($idMedecin);
        $rdv = new ReservationRdv();
        $rdv->setPatient($patient);
        $rdv->setMedecin($medecin);
        $rdv->setStatut("en attente");
        $form = $this->createForm(ReservatioRdvType::class, $rdv);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rdv);
            $entityManager->flush();
            return $this->redirectToRoute('app_reservation_listes_patient', ['id' => $idPatient], Response::HTTP_SEE_OTHER);
        }
        return $this->render('reservation_rdv/new.html.twig', [
            'idPatient' => $idPatient,
            'idMedecin' => $idMedecin,
            'form' => $form,
        ]);
    }

    #[Route('/{idPatient}/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, int $idPatient, ReservationRdvRepository $rep): Response
    {
        $rdv = $rep->find($id);
        $idPatient = $rdv->getPatient()->getIdPatient();
        $form = $this->createForm(ReservatioRdvType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rdv);
            $entityManager->flush();
            return $this->redirectToRoute('app_reservation_show', [
                'idPatient' => $idPatient,
                'id' => $id,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation_rdv/edit.html.twig', [
            'idPatient' => $idPatient,
            'id' => $id,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{idPatient}/{id}', name: 'app_reservation_delete', methods: ['GET', 'POST'])]
    public function delete(EntityManagerInterface $entityManager, PatientRepository $rep1, ReservationRdvRepository $rep2, $id, $idPatient): Response
    {
        $rdv = $rep2->find($id);
        if ($rdv !== null) {
            $p = $rep1->find($idPatient);
            $nbrAnnulations = $p->getNbAnnulations();
            $p->setNbAnnulations($nbrAnnulations + 1);
            $entityManager->remove($rdv);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_reservation_listes_patient', ['id' => $idPatient,], Response::HTTP_SEE_OTHER);
    }

    // ------------------------Medecin---------------------------

    #[Route('/listRdv/{idMedecin}', name: 'app_reservation_listes_medecin')]
    public function rdvList(EntityManagerInterface $entityManager, ReservationRdvRepository $reservationRepository, $idMedecin): Response
    {
        $medecin = $entityManager->getRepository(Med::class)->find($idMedecin);
        $reservations = $reservationRepository->findBy(['medecin' => $medecin]);

        return $this->render('reservation_rdv/listesMedecin.html.twig', [
            'medecin' => $medecin,
            'reservations' => $reservations,
        ]);
    }
    // ------------------------Admin---------------------------


    #[Route('/list', name: 'app_reservation_listes', methods: ['GET'])]
    public function list(ReservationRdvRepository $reservationRdvRepository): Response
    {
        return $this->render('admin_rdv/listes.html.twig', [
            'listesrdvs' => $reservationRdvRepository->findAll(),
        ]);
    }
}
