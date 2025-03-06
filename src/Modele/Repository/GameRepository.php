<?php

namespace App\Modele\Repository;

use App\Modele\DataObject\AbstractDataObject;
use App\Modele\DataObject\Game;

class GameRepository extends AbstractRepository
{


    protected function getTableName(): string
    {
        return 'game';
    }

    protected function getPrimaryKeyNames(): array
    {
        return ['id'];
    }

    protected function getColumnNames(): array
    {
        return ['id',  'description', 'difficulter'];
    }

    protected function formatSQLArray(AbstractDataObject $objet): array
    {

        return array(
            'id' => $objet->getId(),
            'description' => $objet->getDescription(),
            'difficulter' => $objet->getDifficulter(),
        );
    }

    protected function constructFromSQLArray(array $objetFormatTableau): AbstractDataObject
    {
        return new Artiste(
            $objetFormatTableau['id'],
            $objetFormatTableau['description'],
            $objetFormatTableau['difficulter'],
        );
    }


}