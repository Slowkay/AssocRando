<?php

namespace App\Controller;

use App\Repository\HikingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HikeController extends AbstractController
{

    #[Route('/Randonnée/{id}', name: 'hikeInformation')]
    public function hikeById($id, HikingRepository $hikingRepository): Response
    {
        $hike = $hikingRepository->find($id);
        return $this->render('pages/hikes/hikeInformation.html.twig', [
            'hike' => $hike
        ]);
    }

}