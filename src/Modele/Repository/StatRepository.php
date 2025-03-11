<?php

namespace App\Modele\Repository;

use App\Modele\DataObject\AbstractDataObject;
use App\Modele\DataObject\Stat;

class StatRepository extends    AbstractRepository
{
    protected function getTableName(): string
    {
        return 'stat';
    }

    protected function getPrimaryKeyNames(): array
    {
            return ['nom_de_scene', 'login', 'id'];
    }

    protected function getColumnNames(): array
    {
        return ['nom_de_scene', 'login', 'id', 'nbrTentative', 'nbrArtisteTrouver'];
    }

    protected function formatSQLArray(AbstractDataObject $objet): array
    {

        return array(
            'nom_de_scene' => $objet->getNomDeScene(),
            'login' => $objet->getLogin(),
            'id' => $objet->getId(),
            'nbrTentative' => $objet->getNbrTentative(),
            'nbrArtisteTrouver' => $objet->getNbrArtisteTrouver(),
        );
    }

    protected function constructFromSQLArray(array $objetFormatTableau): AbstractDataObject
    {

        return new Stat(
            $objetFormatTableau['nom_de_scene'],
            $objetFormatTableau['login'],
            $objetFormatTableau['id'],
            $objetFormatTableau['nbrTentative'],
            $objetFormatTableau['nbrArtisteTrouver']
        );
    }





}