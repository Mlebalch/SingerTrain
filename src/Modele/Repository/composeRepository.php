<?php

namespace App\Modele\Repository;

use App\Lib\ConnexionBaseDeDonnees;
use App\Modele\DataObject\AbstractDataObject;

use App\Modele\DataObject\compose;

class composeRepository extends AbstractRepository
{

    public function getTableName(): string
    {
        return "compose";
    }

    public function getPrimaryKeyNames(): array
    {
        return ["nom_de_scene"];
    }

    public function getColumnNames(): array
    {
        return ["nom_de_scene", "langue", "type"];
    }

    public function getColumnNamesForUpdate(): array
    {
        return ["langue", "type"];
    }

    public function formatSQLArray(AbstractDataObject $objet): array
    {
        /** @var compose $objet */
        return array(
            "nom_de_scene" => $objet->getNomDeScene(),
            "langue" => $objet->getLangue(),
            "type" => $objet->getType(),
        );
    }

    public function constructFromSQLArray(array $objetFormatTableau): AbstractDataObject
    {
        return new compose(
            $objetFormatTableau['nom_de_scene'],
            $objetFormatTableau['langue'],
            $objetFormatTableau['type'],
        );
    }


    public function getByRand(string $langue, ?string $type = null): array
    {
        $sql = "SELECT * FROM compose WHERE langue = :langue";
        $params = ['langue' => $langue];

        if ($type !== null) {
            $sql .= " AND type = :type";
            $params['type'] = $type;
        }

        $sql .= " ORDER BY RAND()";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute($params);
        $result = array();
        foreach ($pdoStatement->fetchAll() as $row) {
            $result[] = $this->constructFromSQLArray($row);
        }
        return $result;
    }

}