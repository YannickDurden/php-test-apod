<?php

namespace App\DTO;

class ApodDTO
{
    private string $title;
    private string $explanation;
    private string $copyright;
    private \DateTime $date;
    private string $hdurl;
    private string $mediaType;
    private string $serviceVersion;
    private string $url;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getExplanation(): string
    {
        return $this->explanation;
    }

    public function setExplanation(string $explanation): void
    {
        $this->explanation = $explanation;
    }

    public function getCopyright(): string
    {
        return $this->copyright;
    }

    public function setCopyright(string $copyright): void
    {
        $this->copyright = $copyright;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(string $apodDate): void
    {
        $date = new \DateTime($apodDate);
        $this->date = $date;
    }

    public function getHdurl(): string
    {
        return $this->hdurl;
    }

    public function setHdurl(string $hdurl): void
    {
        $this->hdurl = $hdurl;
    }

    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    public function setMediaType(string $mediaType): void
    {
        $this->mediaType = $mediaType;
    }

    public function getServiceVersion(): string
    {
        return $this->serviceVersion;
    }

    public function setServiceVersion(string $serviceVersion): void
    {
        $this->serviceVersion = $serviceVersion;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

}