<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class POTD
{
    private $client;
    private $nasaApiKey;

    public function __construct(HttpClientInterface $client, $nasaApiKey)
    {
        $this->client = $client;
        $this->nasaApiKey = $nasaApiKey;
    }

    private function getNasaApiKey()
    {
        return $this->nasaApiKey;
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws \Exception
     */
    public function fetchPictureOfTheDay(): array
    {
        $url = sprintf(
            "https://api.nasa.gov/planetary/apod?api_key=%s",
            $this->nasaApiKey
        );

        $response = $this->client->request('GET', $url);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new \Exception("Picture of the day cannot be fetch");
        }

        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }

    public function savePictureOfTheDay($url)
    {
        // save here
    }
}