<?php

namespace App\Controller;

use App\Repository\HikingRepository;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HikeController extends AbstractController
{
    // ===== Functions =====

    /**
     * Return the hikes and their sessions
     *
     * @param [type] $idHike
     * @param SessionRepository $sessionRepository
     * @param HikingRepository $hikingRepository
     * @return Response
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
}