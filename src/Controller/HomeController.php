<?php

namespace App\Controller;

use App\Service\POTD;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HomeController extends AbstractController
{
    private $pictureOfTheDayService;
    public function __construct(POTD $pictureOfTheDayService)
    {
        $this->pictureOfTheDayService = $pictureOfTheDayService;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function index()
    {
        $pictureOfTheDay = $this->pictureOfTheDayService->fetchPictureOfTheDay();
        return $this->json($pictureOfTheDay);
    }
}