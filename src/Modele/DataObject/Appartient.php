<?php

namespace App\Modele\DataObject;

class Appartient extends AbstractDataObject
{
    private string $nom_de_scene;
    private string $nom_de_scene_1;
    private string $role;

    public function __construct(string $nom_de_scene, string $nom_de_scene_1, string $role)
    {
        $this->nom_de_scene = $nom_de_scene;
        $this->nom_de_scene_1 = $nom_de_scene_1;
        $this->role = $role;
    }

    public function getNomDeScene(): string
    {
        return $this->nom_de_scene;
    }

    public function setNomDeScene(string $nom_de_scene): void
    {
        $this->nom_de_scene = $nom_de_scene;
    }

    public function getNomDeScene1(): string
    {
        return $this->nom_de_scene_1;
    }

    public function setNomDeScene1(string $nom_de_scene_1): void
    {
        $this->nom_de_scene_1 = $nom_de_scene_1;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }


  public function __toString(): string
    {
        return $this->nom_de_scene . ' ' . $this->nom_de_scene_1 . ' ' . $this->role;
    }

}