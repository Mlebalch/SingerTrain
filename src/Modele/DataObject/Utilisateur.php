<?php

namespace App\Modele\DataObject;

class Utilisateur extends AbstractDataObject
{
    private string $login ;
    private string $mdp;
    private string $email;

    private string $role;


    public function __construct(string $login, string $mdp, string $email, string $role)
    {
        $this->login = $login;
        $this->mdp = $mdp;
        $this->email = $email;
        $this->role = $role;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getMdp(): string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): void
    {
        $this->mdp = $mdp;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
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
        return "Utilisateur[login=$this->login, mdp=$this->mdp, email=$this->email, role=$this->role]";
    }

}