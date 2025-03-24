<?php

namespace App\Modele\DataObject;

class Langue extends AbstractDataObject
{
    private string $langue;
    private string $Accept_Language;
    private string $X_Region;

    public function __construct(string $langue, string $Accept_Language, string $X_Region)
    {
        $this->langue = $langue;
        $this->Accept_Language = $Accept_Language;
        $this->X_Region = $X_Region;
    }

    public function getLangue(): string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): void
    {
        $this->langue = $langue;
    }

    public function getAcceptLanguage(): string
    {
        return $this->Accept_Language;
    }

    public function setAcceptLanguage(string $Accept_Language): void
    {
        $this->Accept_Language = $Accept_Language;
    }

    public function getXRegion(): string
    {
        return $this->X_Region;
    }

    public function setXRegion(string $X_Region): void
    {
        $this->X_Region = $X_Region;
    }

    public function __toString(): string
    {
        return $this->langue;
    }


}