<?php

namespace App\Modele\DataObject;

class Game
{

    private int  $id ;
    private string $description;
    private string $difficulter;


    public function __construct(int $id, string $description, string $difficulter)
    {
        $this->id = $id;
        $this->description = $description;
        $this->difficulter = $difficulter;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDifficulter(): string
    {
        return $this->difficulter;
    }

    public function setDifficulter(string $difficulter): void
    {
        $this->difficulter = $difficulter;
    }


    public function __toString(): string
    {
        return "Game[id=$this->id, description=$this->description, difficulter=$this->difficulter]";
    }
}