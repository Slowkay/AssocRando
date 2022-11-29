<?php

namespace App\Controller;

use App\Repository\HikingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // ===== Functions =====

    /**
     * Return the home page with the hikes
     *
     * @param HikingRepository $hikingRepository
     * @return Response
     */
    #[Route('/', name: 'home')]
    public function index(HikingRepository $hikingRepository): Response
    {    
        // Recovery of all hikes
        $hikes = $hikingRepository->findAll();
        
        return $this->render('pages/home.html.twig', [
            'hikes' => $hikes
        ]);
    }
}