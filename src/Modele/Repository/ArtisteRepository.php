<?php

namespace App\Modele\Repository;

use App\Lib\ConnexionBaseDeDonnees;
use App\Modele\DataObject\AbstractDataObject;
use App\Modele\DataObject\Artiste;
class ArtisteRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'Artiste';
    }

    protected function getPrimaryKeyNames(): array
    {
        return ['nom_de_scene'];
    }

    protected function getColumnNames(): array
    {
        return ['nom_de_scene', 'prenom', 'nom', 'lien_deezer', 'lien_nautijon'];
    }

    protected function formatSQLArray(AbstractDataObject $objet): array
    {

        return array(
            'nom_de_scene' => $objet->getNomDeScene(),
            'prenom' => $objet->getPrenom(),
            'nom' => $objet->getNom(),
            'lien_deezer' => $objet->getLienDeezer(),
            'lien_nautijon' => $objet->getLienNautijon(),
        );
    }

    protected function constructFromSQLArray(array $objetFormatTableau): AbstractDataObject
    {
        return new Artiste(
            $objetFormatTableau['nom_de_scene'],
            $objetFormatTableau['prenom'],
            $objetFormatTableau['nom'],
            $objetFormatTableau['lien_deezer'],
            $objetFormatTableau['lien_nautijon'],
        );
    }

    public function getRand()
{
    $pdo = ConnexionBaseDeDonnees::getPdo();
    $stmt = $pdo->query("SELECT * FROM " . $this->getTableName() . " ORDER BY RAND()");
    $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $artists = [];
    foreach ($results as $row) {
        if (!empty($row['lien_deezer'])) {
            $artists[] = $this->constructFromSQLArray($row);
        }
    }

    return $artists;
}

}