<?php

namespace App\Modele\DataObject;

class Langue extends AbstractDataObject
{
    private string $langue;
    public function __construct(string $langue)
    {
        $this->langue = $langue;
    }

    public function getLangue(): string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): void
    {
        $this->langue = $langue;
    }

    public function __toString(): string
    {
        return $this->langue;
    }


}