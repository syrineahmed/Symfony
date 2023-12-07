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



class UserPatientController extends AbstractController
{
    #[Route('/userpatient', name: 'userapp_patient')]
    public function index(): Response
    {
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
        ]);
    }
#[Route('/add_userpatient', name: 'add_userpatient')]
public function adduserPatient(ManagerRegistry $manager, Request $request): Response
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

    return $this->renderForm('patient/add_UserPatient.html.twig', [
        'form' => $form,
    ]);
    
}}