<?php

namespace App\Controller;
use App\Form\HotelsSearchType;
use App\Entity\Hotels;
use App\Repository\HotelsRepository;
use App\Form\HotelsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hotels')]
class HotelsController extends AbstractController
{
    private HotelsRepository $hotelsRepository;

    public function __construct(HotelsRepository $hotelsRepository)
    {
        $this->hotelsRepository = $hotelsRepository;
    }

    #[Route('/', name: 'app_hotels_index', methods: ['GET', 'POST'])]
    public function index(Request $request, HotelsRepository $hotelsRepository): Response
    {
        $searchForm = $this->createForm(HotelsSearchType::class); // Utilisez HotelsSearchType ici
        $searchForm->handleRequest($request);

        $hotels = [];

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            // Si le formulaire de recherche est soumis, utilisez la logique de recherche
            $searchTerm = $searchForm->get('search')->getData();
            $hotels = $hotelsRepository->findBySearchTerm($searchTerm);
        } else {
            // Sinon, affichez tous les hôtels
            $hotels = $hotelsRepository->findAll();
        }

        $form = $this->createForm(HotelsType::class);

        return $this->render('hotels/index.html.twig', [
            'hotels' => $hotels,
            'searchForm' => $searchForm->createView(),
            'form' => $form->createView(),
        ]);
    }

   
    

    #[Route('/new', name: 'app_hotels_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hotel = new Hotels();
        $form = $this->createForm(HotelsType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hotel);
            $entityManager->flush();

            return $this->redirectToRoute('app_hotels_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hotels/new.html.twig', [
            'hotel' => $hotel,
            'form' => $form,
        ]);
    }

    #[Route('/{idHotel}', name: 'app_hotels_show', methods: ['GET'])]
    public function show(Hotels $hotel): Response
    {
        return $this->render('hotels/show.html.twig', [
            'hotel' => $hotel,
        ]);
    }

    #[Route('/{idHotel}/edit', name: 'app_hotels_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $idHotel, HotelsRepository $hotelsRepository, EntityManagerInterface $entityManager): Response
    {
        $hotel = $hotelsRepository->find($idHotel);
    
        if (!$hotel) {
            // Gérer le cas où l'hôtel n'est pas trouvé
            $this->addFlash('error', 'L\'hôtel n\'existe pas.');
            return $this->redirectToRoute('app_hotels_index');
        }
    
        $form = $this->createForm(HotelsType::class, $hotel);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_hotels_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('hotels/edit.html.twig', [
            'hotel' => $hotel,
            'form' => $form,
        ]);
    }
    

    #[Route('/{idHotel}', name: 'app_hotels_delete', methods: ['POST'])]
    public function delete(Request $request, Hotels $hotel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hotel->getIdHotel(), $request->request->get('_token'))) {
            $entityManager->remove($hotel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hotels_index', [], Response::HTTP_SEE_OTHER);
    }
}
