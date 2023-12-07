<?php

namespace App\Controller;
use App\Repository\UserHotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatPaysController extends AbstractController
{
    #[Route('/stat', name: 'app_stat_pays')]
    public function countUsers(UserHotelRepository $userhotelRepository): Response
    {
        $userHotelByObject = $userhotelRepository->countUsersByObject();

        return $this->render('stat_pays/index.html.twig', [
            'userHotelByObject' => $userHotelByObject,
        ]);
    }
}

