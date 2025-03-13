<?php

namespace App\Modele\Repository;

use App\Lib\ConnexionBaseDeDonnees;
use App\Modele\DataObject\AbstractDataObject;
use App\Modele\DataObject\Appartient;

class AppartientRepository extends AbstractRepository
{
    public function getTableName(): string
    {
        return "appartient";
    }

    public function getPrimaryKeyNames(): array
    {
        return ["nom_de_scene", "nom_de_scene_1"];
    }

    public function getColumnNames(): array
    {
        return ["nom_de_scene", "nom_de_scene_1", "role"];
    }

    public function getColumnNamesForUpdate(): array
    {
        return ["role"];
    }

    public function formatSQLArray(AbstractDataObject $objet): array
    {
        /** @var Appartient $objet */
        return array(
            "nom_de_scene" => $objet->getNomDeScene(),
            "nom_de_scene_1" => $objet->getNomDeScene1(),
            "role" => $objet->getRole(),
        );
    }

    public function constructFromSQLArray(array $objetFormatTableau): AbstractDataObject
    {
        return new Appartient(
            $objetFormatTableau['nom_de_scene'],
            $objetFormatTableau['nom_de_scene_1'],
            $objetFormatTableau['role']
        );
    }

    public function addRole($nom_de_scene, $nom_de_scene_1, $role): void
    {
        $sql = "INSERT INTO appartient (nom_de_scene, nom_de_scene_1, role) VALUES (:nom_de_scene, :nom_de_scene_1, :role)";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute(['nom_de_scene' => $nom_de_scene, 'nom_de_scene_1' => $nom_de_scene_1, 'role' => $role]);

    }

}