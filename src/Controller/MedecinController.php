<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Form\MedecinSearchType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MedecinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class MedecinController extends AbstractController
{

   
    
    #[Route('/medecin', name: 'app_medecin', methods: ['GET', 'POST'])]
    public function index(Request $request, MedecinRepository $medecinRepository): Response
    {
        $searchForm = $this->createForm(MedecinSearchType::class);
        $searchForm->handleRequest($request);
    
        $medecins = []; // Fix the variable name here
    
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            // If the search form is submitted, use the search logic
            $searchTerm = $searchForm->get('search')->getData(); // Check the actual field name in your form type
            $medecins = $medecinRepository->findBySearchTerm($searchTerm);
        } else {
            // Otherwise, display all medecins
            $medecins = $medecinRepository->findAll();
        }
    
        $form = $this->createForm(MedecinSearchType::class);
    
        return $this->render('medecin/list_Medecins.html.twig', [
            'medecins' => $medecins, // Fix the variable name here
            'searchForm' => $searchForm->createView(),
            
        ]);
    }

    #[Route('/search_medecin', name: 'search_medecin', methods: ['GET'])]
    public function searchMedecin(Request $request, MedecinRepository $medecinRepository): Response
    {
        $searchTerm = $request->query->get('searchInput', '');

        $medecins = [];

        if (!empty($searchTerm)) {
            $medecins = $medecinRepository->findBySearchTerm($searchTerm);
        }

        return $this->render('medecin/list_Medecins.html.twig', [
            'medecins' => $medecins,
        ]);
    }
















    
    #[Route('/list_medecins', name: 'list_medecins')]
    public function listMedecins(MedecinRepository $repo): Response
    {
        $medecins = $repo->findAll(); // Change the method name and repository class
    
        return $this->render('medecin/list_Medecins.html.twig', [
            'medecins' => $medecins,
        ]);
    }
    #[Route('/add_medecin', name: 'add_medecin')]
public function addMedecin(ManagerRegistry $manager, Request $request): Response
{
    $em = $manager->getManager();

    $medecin = new Medecin();

    $form = $this->createForm(MedecinType::class, $medecin); // Assuming you have a MedecinType form class

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // You can perform additional actions here before persisting the medecin entity

        $em->persist($medecin);
        $em->flush();
        $this->sendTwilioMessage($medecin);


        return $this->redirectToRoute('list_medecins');
    }

    return $this->renderForm('medecin/add_Medecin.html.twig', [
        'form' => $form,
    ]);
}
#[Route('/medecin/{id}', name: 'show_medecin', methods: ['GET'])]
public function show(Medecin $medecin): Response
{
    return $this->render('medecin/show.html.twig', [
        'medecin' => $medecin,
    ]);
}

#[Route('/medecin/{id}/edit', name: 'edit_medecin', methods: ['GET', 'POST'])]
public function edit(Request $request, int $id, EntityManagerInterface $entityManager, MedecinRepository $medecinRepository): Response
{
    $medecin = $medecinRepository->find($id);

    if (!$medecin) {
        throw $this->createNotFoundException('Medecin not found');
    }

    $form = $this->createForm(MedecinType::class, $medecin);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('list_medecins', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('medecin/edit.html.twig', [
        'medecin' => $medecin,
        'form' => $form,
    ]);
}

#[Route('/medecin/{id}/delete', name: 'delete_medecin', methods: ['POST'])]
public function delete(Request $request, Medecin $medecin, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$medecin->getId(), $request->request->get('_token'))) {
        $entityManager->remove($medecin);
        $entityManager->flush();
    }

    return $this->redirectToRoute('list_medecins', [], Response::HTTP_SEE_OTHER);
}
private function sendTwilioMessage(Medecin $medecin): void
    {
        $twilioAccountSid = $this->getParameter('twilio_account_sid');
        $twilioAuthToken = $this->getParameter('twilio_auth_token');
        $twilioPhoneNumber = $this->getParameter('twilio_phone_number');

        $twilioClient = new Client($twilioAccountSid, $twilioAuthToken);

        // Replace 'to' with the recipient phone number
        // Replace 'from' with your Twilio phone number
        $twilioClient->messages->create(
            '+21693728865', // Replace with the recipient's phone number
            [
                'from' => $twilioPhoneNumber,
                'body' => 'This doctor has been added: ' . $medecin->getNom(),
            ]
        );
    }
    #[Route('/firstpage', name: 'first_page')]
    public function firstPageAction(): Response
    {
        return $this->render('medecin/Firstpage.html.twig');
    }
    

    
}

