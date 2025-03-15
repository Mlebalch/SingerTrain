<?php

namespace App\Modele\Repository;

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
            return ["id"];
        }

        public function getColumnNames(): array
        {
            return ["id", "id_categorie", "id_langue"];
        }

        public function getColumnNamesForUpdate(): array
        {
            return ["id_categorie", "id_langue"];
        }

        public function formatSQLArray(AbstractDataObject $objet): array
        {
            /** @var compose $objet */
            return array(
                "id" => $objet->getId(),
                "id_categorie" => $objet->getIdCategorie(),
                "id_langue" => $objet->getIdLangue(),
            );
        }

        public function constructFromSQLArray(array $objetFormatTableau): AbstractDataObject
        {
            return new compose(
                $objetFormatTableau['id'],
                $objetFormatTableau['id_categorie'],
                $objetFormatTableau['id_langue'],
            );
        }

}