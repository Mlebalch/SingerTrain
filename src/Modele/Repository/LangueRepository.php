<?php

namespace App\Modele\Repository;

use App\Modele\DataObject\AbstractDataObject;
use App\Modele\DataObject\Langue;

class LangueRepository extends AbstractRepository
{

    public function getTableName(): string
    {
        return "langue";
    }

    public function getPrimaryKeyNames(): array
    {
        return ["langue"];
    }

    public function getColumnNames(): array
    {
        return ["langue"];
    }

    public function getColumnNamesForUpdate(): array
    {
        return ["langue"];
    }

    public function formatSQLArray(AbstractDataObject $objet): array
    {
        /** @var Langue $objet */
        return array(
            "langue" => $objet->getLangue(),
        );
    }

    public function constructFromSQLArray(array $objetFormatTableau): AbstractDataObject
    {
        return new Langue(
            $objetFormatTableau['langue'],
        );
    }

}