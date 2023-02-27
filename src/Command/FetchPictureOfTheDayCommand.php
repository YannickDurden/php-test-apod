<?php

namespace App\Command;

use App\ApodManager;
use App\Service\ApodService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class FetchPictureOfTheDayCommand extends Command
{
    protected static $defaultName = 'app:fetch:potd';
    private ApodService $apodService;
    private ApodManager $apodManager;

    public function __construct(ApodService $apodService, ApodManager $apodManager)
    {
        parent::__construct();
        $this->apodService = $apodService;
        $this->apodManager = $apodManager;
    }

    protected function configure(): void
    {
        $this->setDescription("Fetch NASA Picture of the day");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $apod = $this->apodService->fetchPictureOfTheDay();
            if ("image" === $apod['media_type']) {
                $this->apodManager->savePictureOfTheDay($apod);
            }
        } catch (\Exception $exception) {
            $output->write($exception->getMessage());
            return Command::FAILURE;
        }

        $output->write("Picture of the day has been fetched");
        return Command::SUCCESS;
    }
}