<?php

namespace App\Controller;

use App\Service\ApodService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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