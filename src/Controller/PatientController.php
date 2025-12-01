<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\JoinEspaceType;
use App\Form\PatientType;
use App\Model\JoinEspace;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Route('/patient')]
class PatientController extends AbstractController
{
    #[Route('/', name: 'app_patient_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('patient/index.html.twig');
    }

    #[Route('/new', name: 'app_patient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FlashyNotifier $flashy, EntityManagerInterface $entityManager): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$patient->setBlocked(false);
            $patient->setNbAnnulations(0);
            $entityManager->persist($patient);
            $entityManager->flush();
            $flashy->success('Espace creé avec succes');
            return $this->render(
                'patient/espace.html.twig',
                ['id' => $patient->getIdPatient(), 'patient' => $patient,]
            );
        }
        return $this->render('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/join', name: 'app_patient_join', methods: ['GET', 'POST'])]
    public function join(Request $request, PatientRepository $patientRepository,  UrlGeneratorInterface $urlGenerator): Response
    {
        $url = $urlGenerator->generate('app_patient_index');
        $form = $this->createFormBuilder()
            ->add('email', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre adresse e-mail.']),
                    new Email(['message' => 'L\'adresse e-mail "{{ value }}" n\'est pas valide.']),
                ],
            ])
            ->add('submit', SubmitType::class, ['label' => 'Aller', 'attr' => ['class' => 'btn btn-primary']])
            ->add('cancel', ButtonType::class, [
                'label' => 'Annuler',
                'attr' => [
                    'class' => 'btn btn-outline-primary',
                    'formnovalidate' => 'formnovalidate',
                    'onclick' => "window.location.href='$url'",
                ],
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $patient = $patientRepository->findOneBy(['email_P' => $data['email']]);
            if ($patient) {

                return $this->redirectToRoute('app_patient_espace', ['id' => $patient->getIdPatient(),]);
            }
        }
        return $this->render('patient/login.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/espace/{id}', name: 'app_patient_espace', methods: ['GET'])]
    public function espace(int $id, FlashyNotifier $flashy, PatientRepository $patientRepository): Response
    {
        $patient = $patientRepository->findOneBy(['id' => $id]);
        $flashy->success('Bienvenue à votre espace');
        return $this->render('patient/espace.html.twig', ['id' => $id, 'patient' => $patient]);
    }


    #[Route('/{id}', name: 'app_patient_show', methods: ['GET'])]
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_patient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, PatientRepository $rep): Response
    {
        $patient = $rep->find($id);
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($patient);
            $entityManager->flush();
            return $this->redirectToRoute('app_patient_show', ['id' => $patient->getIdPatient(),], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_patient_delete', methods: ['POST'])]
    public function delete(EntityManagerInterface $entityManager, PatientRepository $rep, $id): Response
    {
        $patient = $rep->find($id);
        $entityManager->remove($patient);
        $entityManager->flush();
        return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
    }



    #---------------------------------ADMIN--------------------------------



    #[Route('/admin', name: 'app_patient_list_admin', methods: ['GET'])]
    public function indexAdmin(PatientRepository $patientRepository): Response
    {
        return $this->render('admin_patient/dashboard__tables.html.twig', [
            'patients' => $patientRepository->findAll(),
        ]);
    }

    #[Route('/admin/new', name: 'app_patient_new_admin', methods: ['GET', 'POST'])]
    public function newPatient(Request $request, EntityManagerInterface $entityManager): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('app_patient_list_admin', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin_patient/dashboard__new_patient.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}', name: 'app_patient_show_admin', methods: ['GET'])]
    public function showPatient(Patient $patient): Response
    {
        return $this->render('admin_patient/dashboard__show__patient.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_patient_edit_admin', methods: ['GET', 'POST'])]
    public function editAdmin(Request $request, EntityManagerInterface $entityManager, int $id, PatientRepository $rep): Response
    {
        $patient = $rep->find($id);
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($patient);
            $entityManager->flush();
            return $this->redirectToRoute('app_patient_list_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_patient/dashboard__update__patient.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/admin/delete/{id}', name: 'app_patient_delete_admin', methods: ['POST'])]
    public function deletePatient(EntityManagerInterface $entityManager, PatientRepository $rep, $id): Response
    {
        $patient = $rep->find($id);
        $entityManager->remove($patient);
        $entityManager->flush();
        return $this->redirectToRoute('app_patient_list_admin', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/block/patient/{id}', name: 'app_patient_admin_block', methods: ['GET'])]
    public function blockPatient(EntityManagerInterface $entityManager, PatientRepository $rep, $id): Response
    {
        $patient = $rep->find($id);
        $patient->setBlocked(true);
        $entityManager->flush();
        return $this->redirectToRoute('app_patient_list_admin', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/deblock/patient/{id}', name: 'app_patient_admin_deblock', methods: ['GET'])]
    public function deblouque(EntityManagerInterface $entityManager, PatientRepository $rep, $id): Response
    {
        $patient = $rep->find($id);
        $patient->setBlocked(false);
        $entityManager->flush();
        return $this->redirectToRoute('app_patient_list_admin', [], Response::HTTP_SEE_OTHER);
    }
}
