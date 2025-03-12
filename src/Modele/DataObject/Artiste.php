<?php

namespace App\Modele\DataObject;

class Artiste extends AbstractDataObject
{
    private string $nom_de_scene ;
    private string $prenom;
    private string $nom;
    private int $lien_deezer;
    private string $lien_nautijon;
    private string $image;


    public function __construct(string $nom_de_scene, string $prenom, string $nom, int $lien_deezer, string $lien_nautijon, string $image)
    {
        $this->nom_de_scene = $nom_de_scene;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->lien_deezer = $lien_deezer;
        $this->lien_nautijon = $lien_nautijon;
        $this->image = $image;

    }

    public function getNomDeScene(): string
    {
        return $this->nom_de_scene;
    }

    public function setNomDeScene(string $nom_de_scene): void
    {
        $this->nom_de_scene = $nom_de_scene;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getLienDeezer(): int
    {
        return $this->lien_deezer;
    }

    public function setLienDeezer(int $lien_deezer): void
    {
        $this->lien_deezer = $lien_deezer;
    }

    public function getLienNautijon(): string
    {
        return $this->lien_nautijon;
    }

    public function setLienNautijon(string $lien_nautijon): void
    {
        $this->lien_nautijon = $lien_nautijon;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function __toString()
    {

        return "Artiste[nom_de_scene=$this->nom_de_scene, prenom=$this->prenom, nom=$this->nom, lien_deezer=$this->lien_deezer, lien_nautijon=$this->lien_nautijon, image=$this->image]";
    }


}