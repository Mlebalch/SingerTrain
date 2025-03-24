<?php

namespace App\Modele\Repository;

use App\Lib\ConnexionBaseDeDonnees;
use App\Modele\DataObject\AbstractDataObject;
use App\Modele\DataObject\Categorie;

class CategorieRepository extends AbstractRepository
{

    public function getTableName(): string
    {
        return "Categorie";
    }

    public function getPrimaryKeyNames(): array
    {
        return ["type"];
    }

    public function getColumnNames(): array
    {
        return ["type", "description"];
    }

    public function getColumnNamesForUpdate(): array
    {
        return ["description"];
    }

    public function formatSQLArray(AbstractDataObject $objet): array
    {
        /** @var Categorie $objet */
        return array(
            "type" => $objet->getType(),
            "description" => $objet->getDescription(),
        );
    }

    public function constructFromSQLArray(array $objetFormatTableau): AbstractDataObject
    {
        return new Categorie(
            $objetFormatTableau['type'],
            $objetFormatTableau['description'] ?? null,
        );
    }


public function getByLangue(string $langue): array
{
    $sql = "SELECT DISTINCT( Categorie.type), Categorie.description FROM " . $this->getTableName() . " JOIN compose ON Categorie.type = compose.type WHERE compose.langue = :langue";
    $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
    $pdoStatement->execute(['langue' => $langue]);
    $resultat = array();
    foreach ($pdoStatement->fetchAll() as $row) {
        $resultat[] = $this->constructFromSQLArray($row);
    }
    return $resultat;
}
}