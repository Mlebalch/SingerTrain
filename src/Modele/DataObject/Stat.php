<?php

namespace App\Modele\DataObject;

class Stat extends AbstractDataObject
{
    private string $nom_de_scene ;
    private string $login;
    private int  $id;
    private int $nbrTentative;
    private int $nbrArtisteTrouver;
    private int $nbrPartie;

    public function __construct(string $nom_de_scene, string $login, int $id, int $nbrTentative, int $nbrArtisteTrouver, int $nbrPartie)
    {
        $this->nom_de_scene = $nom_de_scene;
        $this->login = $login;
        $this->id = $id;
        $this->nbrTentative = $nbrTentative;
        $this->nbrArtisteTrouver = $nbrArtisteTrouver;
        $this->nbrPartie = $nbrPartie;
    }

    public function getNomDeScene(): string
    {
        return $this->nom_de_scene;
    }

    public function setNomDeScene(string $nom_de_scene): void
    {
        $this->nom_de_scene = $nom_de_scene;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNbrTentative(): int
    {
        return $this->nbrTentative;
    }

    public function setNbrTentative(int $nbrTentative): void
    {
        $this->nbrTentative = $nbrTentative;
    }

    public function getNbrArtisteTrouver(): int
    {
        return $this->nbrArtisteTrouver;
    }

    public function setNbrArtisteTrouver(int $nbrArtisteTrouver): void
    {
        $this->nbrArtisteTrouver = $nbrArtisteTrouver;
    }

    public function getNbrPartie(): int
    {
        return $this->nbrPartie;
    }

    public function setNbrPartie(int $nbrPartie): void
    {
        $this->nbrPartie = $nbrPartie;
    }

    public function __toString(): string
    {
        return "Stat[nom_de_scene=$this->nom_de_scene, login=$this->login, id=$this->id, nbrTentative=$this->nbrTentative, nbrArtisteTrouver=$this->nbrArtisteTrouver, nbrPartie=$this->nbrPartie]";
    }
}