<?php

namespace App\Modele\DataObject;

class compose extends AbstractDataObject
{
    private string $nom_de_scene ;
    private string $langue;
    private string $type;

    public function __construct(string $nom_de_scene, string $langue, string $type)
    {
        $this->nom_de_scene = $nom_de_scene;
        $this->langue = $langue;
        $this->type = $type;
    }

    public function getNomDeScene(): string
    {
        return $this->nom_de_scene;
    }

    public function setNomDeScene(string $nom_de_scene): void
    {
        $this->nom_de_scene = $nom_de_scene;
    }

    public function getLangue(): string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): void
    {
        $this->langue = $langue;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function __toString(): string
    {
        return $this->nom_de_scene;
    }



}