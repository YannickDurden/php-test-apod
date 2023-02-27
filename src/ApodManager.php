<?php

namespace App;

use App\Entity\Apod;
use App\Repository\ApodRepository;
use Exception;

class ApodManager
{
    private ApodRepository $apodRepository;

    public function __construct(ApodRepository $apodRepository)
    {
        $this->apodRepository = $apodRepository;
    }

    public function savePictureOfTheDay(array $content): Apod
    {
        $date = new \DateTime($content['date']);

        // check if a record already exists for the given date
        $apodFromDb = $this->apodRepository->findOneBy(['date' => $date]);
        if ($apodFromDb instanceof Apod) {
            return $apodFromDb;
        }

        $apod = new Apod();
        $apod->setTitle($content['title'])
            ->setDate($date)
            ->setExplanation($content['explanation'])
            ->setImage($content['hdurl']);

        $this->apodRepository->add($apod, true);

        return $apod;
    }

    public function getLastRecord(): ?Apod
    {
        return $this->apodRepository->findOneBy([], ['id' => 'DESC']);
    }
}