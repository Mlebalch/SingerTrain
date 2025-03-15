<?php

namespace App\Modele\Repository;

use App\Modele\DataObject\AbstractDataObject;
use App\Modele\DataObject\Categorie;

class CategorieRepository extends AbstractRepository
{

    public function getTableName(): string
    {
        return "categorie";
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
            $objetFormatTableau['description'],
        );
    }

}