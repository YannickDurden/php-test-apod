<?php

namespace App\Service;

use Exception;
use App\DTO\ApodDTO;
use App\Entity\Apod;
use App\Manager\ApodManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApodService
{
    private HttpClientInterface $client;
    private string $nasaApiKey;
    private ApodManager $apodManager;
    private LoggerInterface $logger;
    private SerializerInterface $serializer;

    public function __construct(
        HttpClientInterface $client,
        $nasaApiKey,
        ApodManager $apodManager,
        LoggerInterface $logger,
        SerializerInterface $serializer
    ) {
        $this->client = $client;
        $this->nasaApiKey = $nasaApiKey;
        $this->apodManager = $apodManager;
        $this->logger = $logger;
        $this->serializer = $serializer;
    }

    private function getNasaApiKey(): string
    {
        return $this->nasaApiKey;
    }

    public function fetchPictureOfTheDay(): ApodDTO
    {
        $url = sprintf(
            "https://api.nasa.gov/planetary/apod?api_key=%s",
            $this->nasaApiKey
        );

        $response = $this->client->request('GET', $url);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new Exception("Picture of the day cannot be fetch");
        }

        $content = $response->getContent();

        return $this->serializer->deserialize($content, ApodDTO::class, 'json');
    }

    public function getPictureOfTheDay(): ?Apod
    {
        try {
            $apod = $this->fetchPictureOfTheDay();
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage());
            return $this->apodManager->getLastRecord();
        }

        if ("image" !== $apod->getMediaType()) {
            return $this->apodManager->getLastRecord();
        }

        return $this->apodManager->savePictureOfTheDay($apod);
    }
}