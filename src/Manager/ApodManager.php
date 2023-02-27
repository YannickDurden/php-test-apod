<?php

namespace App\Manager;

use App\DTO\ApodDTO;
use App\Entity\Apod;
use App\Repository\ApodRepository;

class ApodManager
{
    private ApodRepository $apodRepository;

    public function __construct(ApodRepository $apodRepository)
    {
        $this->apodRepository = $apodRepository;
    }

    public function savePictureOfTheDay(ApodDTO $apodDTO): Apod
    {
        $apodFromDb = $this->apodRepository->findOneBy(['date' => $apodDTO->getDate()]);
        if ($apodFromDb instanceof Apod) {
            return $apodFromDb;
        }

        $apod = Apod::fromDTO($apodDTO);
        $this->apodRepository->add($apod, true);

        return $apod;
    }

    public function getLastRecord(): ?Apod
    {
        return $this->apodRepository->findOneBy([], ['id' => 'DESC']);
    }
}