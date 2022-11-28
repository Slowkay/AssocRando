<?php

namespace App\Controller;

use App\Repository\HikingRepository;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HikeController extends AbstractController
{
    /**
     * Functions
     */
    #[Route('/Randonnée/{idHike}', name: 'hikeInformation')]
    public function hikeById($idHike, SessionRepository $sessionRepository, HikingRepository $hikingRepository): Response
    {
        $hike = $hikingRepository->find($idHike);
        $session = $sessionRepository->findById($idHike);
        
        return $this->render('pages/hikes/hikeInformation.html.twig', [
            'hike' => $hike,
            'session' => $session
        ]);
    }

    // #[Route('/Randonnée/{idSession}', name: 'hikeInformationSession')]
    // public function hikeByIdSession($idSession, SessionRepository $sessionRepository): Response
    // {
    //     $session = $sessionRepository->find($idSession);
    //     return $this->render('pages/hikes/hikeInformation.html.twig', [
    //         'session' => $session
    //     ]);
    // }

}