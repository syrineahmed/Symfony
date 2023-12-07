<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Patient;
use App\Form\PatientType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;



class PatientController extends AbstractController
{
    #[Route('/patient', name: 'app_patient')]
    public function index(): Response
    {
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
        ]);
    }

    #[Route('/getAllPatients', name: 'list_patients')]
    public function listPatients(PatientRepository $repo): Response
    {
        $patients = $repo->findAll(); /* Select * from patient */
        
        return $this->render('patient/list_Patients.html.twig', [
            'patients' => $patients,
        ]);
    }
    
    #[Route('/add_patient', name: 'add_patient')]
    public function addPatient(ManagerRegistry $manager, Request $request): Response
    {
        $em = $manager->getManager();

        $patient = new Patient();

        $form = $this->createForm(PatientType::class, $patient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // You can perform additional actions here before persisting the patient entity

            $em->persist($patient);
            $em->flush();

            return $this->redirectToRoute('list_patients');
        }

        return $this->renderForm('patient/add_Patient.html.twig', [
            'form' => $form,
        ]);
        
    }




    #[Route('/patient/{id}', name: 'show_patient', methods: ['GET'])]
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }
   
   
    #[Route('/patient/{id}/edit', name: 'edit_patient', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id, EntityManagerInterface $entityManager, PatientRepository $patientRepository): Response
    {
        $patient = $patientRepository->find($id);
    
        if (!$patient) {
            throw $this->createNotFoundException('Patient not found');
        }
    
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            // Correct redirection to 'edit_patient' instead of 'list_patients'
            return $this->redirectToRoute('edit_patient', ['id' => $patient->getId()], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }
    

    #[Route('/patient/{id}/delete', name: 'delete_patient', methods: ['POST'])]
    public function delete(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $patient->getId(), $request->request->get('_token'))) {
            $entityManager->remove($patient);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('list_patients', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/patientfirstpage', name: 'patient_first_page')]
    public function firstPageAction(): Response
    {
        return $this->render('patient/PatientFirstPage.html.twig');
    }

    #[Route('/search_patient', name: 'search_patient', methods: ['GET'])]
public function searchPatient(Request $request, PatientRepository $patientRepository): Response
{
    $searchTerm = $request->query->get('searchInput', '');

    $patients = [];

    if (!empty($searchTerm)) {
        $patients = $patientRepository->findBySearchTerm($searchTerm);
    }

    return $this->render('patient/list_Patients.html.twig', [
        'patients' => $patients,
    ]);
}

}