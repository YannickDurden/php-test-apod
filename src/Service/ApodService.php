<?php

namespace App\Service;

use App\ApodManager;
use App\Entity\Apod;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApodService
{
    private HttpClientInterface $client;
    private string $nasaApiKey;
    private ApodManager $apodManager;
    private LoggerInterface $logger;

    public function __construct(
        HttpClientInterface $client,
        $nasaApiKey,
        ApodManager $apodManager,
        LoggerInterface $logger
    ) {
        $this->client = $client;
        $this->nasaApiKey = $nasaApiKey;
        $this->apodManager = $apodManager;
        $this->logger = $logger;
    }

    private function getNasaApiKey(): string
    {
        return $this->nasaApiKey;
    }

    public function fetchPictureOfTheDay(): array
    {
        // return json_decode(file_get_contents('data.json'), true);

        $url = sprintf(
            "https://api.nasa.gov/planetary/apod?api_key=%s",
            $this->nasaApiKey
        );

        $response = $this->client->request('GET', $url);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new Exception("Picture of the day cannot be fetch");
        }

        $content = $response->getContent();

        return $response->toArray();
    }

    public function getPictureOfTheDay(): ?Apod
    {
        try {
            $apod = $this->fetchPictureOfTheDay();
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage());
            return $this->apodManager->getLastRecord();
        }

        if ("image" !== $apod['media_type']) {
            return $this->apodManager->getLastRecord();
        }

        return $this->apodManager->savePictureOfTheDay($apod);
    }
}