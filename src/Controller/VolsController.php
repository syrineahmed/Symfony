<?php

namespace App\Controller;

use App\Entity\Vols;
use App\Form\VolsType;
use App\Repository\VolsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\VolsSearchType;

#[Route('/vols')]
class VolsController extends AbstractController
{

    private $volsRepository;

    public function __construct(VolsRepository $volsRepository)
    {
        $this->volsRepository = $volsRepository;
    }

    #[Route('/', name: 'app_vols_index', methods: ['GET', 'POST'])]
    public function index(Request $request, VolsRepository $volsRepository): Response
    {
        $searchForm = $this->createForm(VolsSearchType::class);
        $searchForm->handleRequest($request);
    
        $vols = [];
    
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            // Si le formulaire de recherche est soumis, utilisez la logique de recherche
            $searchTerm = $searchForm->get('search')->getData();
            $vols = $volsRepository->findByNomAirways($searchTerm);
        } else {
            // Sinon, affichez tous les vols
            $vols = $volsRepository->findAll();
        }
    
        return $this->render('vols/index.html.twig', [
            'vols' => $vols,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    #[Route('/new', name: 'app_vols_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vol = new Vols();
        $form = $this->createForm(VolsType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vol);
            $entityManager->flush();

            return $this->redirectToRoute('app_vols_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vols/new.html.twig', [
            'vol' => $vol,
            'form' => $form,
        ]);
    }

    #[Route('/{idVol}', name: 'app_vols_show', methods: ['GET'])]
    public function show(Vols $vol): Response
    {
        return $this->render('vols/show.html.twig', [
            'vol' => $vol,
        ]);
    }

    #[Route('/{idVol}/edit', name: 'app_vols_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $idVol, VolsRepository $volsRepository, EntityManagerInterface $entityManager): Response
    {
        $vol = $volsRepository->find($idVol);
    
        if (!$vol) {
            throw $this->createNotFoundException('Vol not found');
        }
    
        $form = $this->createForm(VolsType::class, $vol);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_vols_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('vols/edit.html.twig', [
            'vol' => $vol,
            'form' => $form,
        ]);
    }
    

    #[Route('/{idVol}', name: 'app_vols_delete', methods: ['POST'])]
    public function delete(Request $request, Vols $vol, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vol->getIdVol(), $request->request->get('_token'))) {
            $entityManager->remove($vol);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vols_index', [], Response::HTTP_SEE_OTHER);
    }
}
