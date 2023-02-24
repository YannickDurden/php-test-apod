<?php

namespace App\Command;

use App\Service\POTD;
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
    private $nasaAPI;

    public function __construct(POTD $pictureOfTheDayService)
    {
        $this->pictureOfTheDayService = $pictureOfTheDayService;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription("Fetch NASA Picture of the day");
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $pictureOfTheDay = $this->pictureOfTheDayService->fetchPictureOfTheDay();
            $output->write("POTD has been fetched");
            return Command::SUCCESS;
        } catch (\Exception $exception) {
            $output->write($exception->getMessage());
            return Command::FAILURE;
        }
    }
}