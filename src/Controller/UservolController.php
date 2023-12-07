<?php

namespace App\Controller;

use App\Entity\Uservol;
use App\Form\UservolType;
use App\Entity\Vols;
use App\Repository\VolsRepository;
use App\Repository\UserVolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/uservol')]
class UservolController extends AbstractController
{   
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_uservol_index', methods: ['GET'])]
    public function index(): Response
    {
          $entityManager = $this->getDoctrine()->getManager();
        $VolsRepository = $entityManager->getRepository(Vols::class);
        $vols = $VolsRepository->findAll();

    return $this->render('uservol/index.html.twig', [
        'vols' => $vols, // Change the variable name to 'uservols'
    ]);
    }


    #[Route('/reserve/{idVol}', name: 'app_uservol_reserve', methods: ['GET', 'POST'])]
    public function reserve(Request $request, EntityManagerInterface $entityManager, VolsRepository $volsRepository, int $idVol): Response
    
    {
        
    // Retrieve the selected vol
    $vol = $volsRepository->find($idVol);

    // Check if the vol exists
    if (!$vol) {
        throw $this->createNotFoundException('Vol not found');
    }

    // Create a new instance of Uservol and automatically fill in some information
    $uservol = new Uservol();
    $uservol->setNomCompagnie($vol->getNomAirways());
    $uservol->setDestination($vol->getDestination());
    $uservol->setDateDepart($vol->getDateDepart());
    $uservol->setVol($vol); // Set the association with the vol

    // Create the form
    $form = $this->createForm(UservolType::class, $uservol);

    // Process the form when it is submitted
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Add the reservation to the database
        $entityManager->persist($uservol);

        // Retrieve the price per ticket from the Vols entity
        $prixBillet = $vol->getPrixBillet();

        // Calculate the invoice based on the number of tickets, price per ticket, and other factors
        $nbBillet = $form->get('billetReservee')->getData();
        $facture = $nbBillet * $prixBillet;

        // Set the invoice in the Uservol entity
        $uservol->setFactureVol($facture);

        // Update the number of available tickets in the vol entity
        $vol->setNbBillet($vol->getNbBillet() - $nbBillet);

        // Flush the changes to the database
        $entityManager->flush();

        // Redirect the user to the home page or another desired page after the reservation
        return $this->redirectToRoute('app_userhotel_index');
    }

    // Display the form
    return $this->render('uservol/reserve.html.twig', [
        'form' => $form->createView(),
    ]);
}
 
    #[Route('/new', name: 'app_uservol_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $uservol = new Uservol();
        $form = $this->createForm(UservolType::class, $uservol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($uservol);
            $entityManager->flush();

            return $this->redirectToRoute('app_uservol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('uservol/new.html.twig', [
            'uservol' => $uservol,
            'form' => $form,
        ]);
    }

    #[Route('/{numPassport}', name: 'app_uservol_show', methods: ['GET'])]
    public function show(Uservol $uservol): Response
    {
        return $this->render('uservol/show.html.twig', [
            'uservol' => $uservol,
        ]);
    }

    #[Route('/{numPassport}/edit', name: 'app_uservol_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Uservol $uservol, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UservolType::class, $uservol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_uservol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('uservol/edit.html.twig', [
            'uservol' => $uservol,
            'form' => $form,
        ]);
    }

    #[Route('/{numPassport}', name: 'app_uservol_delete', methods: ['POST'])]
    public function delete(Request $request, Uservol $uservol, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$uservol->getNumPassport(), $request->request->get('_token'))) {
            $entityManager->remove($uservol);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_uservol_index', [], Response::HTTP_SEE_OTHER);
    }
}
