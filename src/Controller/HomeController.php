<?php

namespace App\Controller;

use App\Service\ApodService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private ApodService $apodService;
    public function __construct(ApodService $apodService)
    {
        $this->apodService = $apodService;
    }

    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    public function showApod(): Response
    {
        $pictureOfTheDay = $this->apodService->getPictureOfTheDay();

        return $this->render('home/show_apod.html.twig', [
            'picture_of_the_day' => $pictureOfTheDay
        ]);
    }
}