<?php

namespace App\Modele\Repository;

use App\Modele\DataObject\AbstractDataObject;
use App\Modele\DataObject\Langue;

class LangueRepository extends AbstractRepository
{

    public function getTableName(): string
    {
        return "Langue";
    }

    public function getPrimaryKeyNames(): array
    {
        return ["langue"];
    }

    public function getColumnNames(): array
    {
        return ["langue", "Accept_Language", "X_Region"];
    }

    public function getColumnNamesForUpdate(): array
    {
        return ["Accept_Language", "X_Region"];
    }

    public function formatSQLArray(AbstractDataObject $objet): array
    {
        /** @var Langue $objet */
        return array(
            "langue" => $objet->getLangue(),
            "Accept_Language" => $objet->getAcceptLanguage(),
            "X_Region" => $objet->getXRegion(),
        );
    }

    public function constructFromSQLArray(array $objetFormatTableau): AbstractDataObject
    {
        return new Langue(
            $objetFormatTableau['langue'],
            $objetFormatTableau['Accept_Language'],
            $objetFormatTableau['X_Region'],
        );
    }
}