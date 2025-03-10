<?php

namespace App\Modele\DataObject;

class Artiste extends AbstractDataObject
{
    private string $nom_de_scene ;
    private string $prenom;
    private string $nom;
    private int $lien_deezer;
    private string $lien_nautijon;


    public function __construct(string $nom_de_scene, string $prenom, string $nom, int $lien_deezer, string $lien_nautijon)
    {
        $this->nom_de_scene = $nom_de_scene;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->lien_deezer = $lien_deezer;
        $this->lien_nautijon = $lien_nautijon;
    }

    public function getNomDeScene(): string
    {
        return $this->nom_de_scene;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getLienDeezer(): string
    {
        return $this->lien_deezer;
    }

    public function getLienNautijon(): string
    {
        return $this->lien_nautijon;
    }

    public function __toString(): string
    {
        return "Artiste[nom_de_scene=$this->nom_de_scene, prenom=$this->prenom, nom=$this->nom, lien_deezer=$this->lien_deezer, lien_nautijon=$this->lien_nautijon]";
    }
}