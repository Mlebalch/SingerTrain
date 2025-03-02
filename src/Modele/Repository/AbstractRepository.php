<?php

namespace App\Modele\Repository;
use App\Lib\ConnexionBaseDeDonnees;
use App\Modele\DataObject\AbstractDataObject;

abstract class AbstractRepository
{
    protected abstract function getTableName(): string;
    protected abstract function getPrimaryKeyNames(): array;
    protected abstract function getColumnNames(): array;
    protected abstract function formatSQLArray(AbstractDataObject $objet): array;
    protected abstract function constructFromSQLArray(array $objetFormatTableau): AbstractDataObject;
    protected function getOrder() : ?string { return null; }
    protected function getColumnNamesForUpdate(): array
    {
        return $this->getColumnNames();
    }

    public function get(): array
    {
        $utilisateur = [];
        $sql = "SELECT * FROM " . $this->getTableName();
        if ($this->getOrder() != null) $sql .= " ORDER BY " . $this->getOrder();

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query($sql);
        foreach ($pdoStatement as $utilisateurFormatTableau)
        {
            $utilisateur[] = $this->constructFromSQLArray($utilisateurFormatTableau);
        }
        return $utilisateur;
    }
    public function getByPrimaryKeys(array $primaryKeys): ?AbstractDataObject
    {
        $conditions = [];
        $params = [];
        foreach ($this->getPrimaryKeyNames() as $index => $key) {
            $conditions[] = "$key = :$key";
            $params[$key] = $primaryKeys[$index];
        }


        $sql = "SELECT * from " . $this->getTableName() . " WHERE " . implode(" AND ", $conditions);
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute($params);
        $objetFormatTableau = $pdoStatement->fetch();
        if (!$objetFormatTableau) return null;
        return $this->constructFromSQLArray($objetFormatTableau);
    }


    public function supprimerParClePrimaires(array $primaryKeys): bool
    {
        $conditions = [];
        $params = [];
        foreach ($this->getNomClesPrimaires() as $index => $key) {
            $conditions[] = "$key = :$key";
            $params[$key] = $primaryKeys[$index];
        }
        $sql = "DELETE FROM " . $this->getNomTable() . " WHERE " . implode(" AND ", $conditions);
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        return $pdoStatement->execute($params);
    }

    public function mettreAJour(AbstractDataObject $objet): void
    {
        $tab = $this->getNomColonne($objet);
        $str = " ";
        foreach ($tab as $value) {
            $str = $str . $value . " = :" . $value;
            if ($value != end($tab)): $str = $str .  ", ";
            endif;
        }
        $sql = "UPDATE " . $this->getNomTable() . " SET " . $str . " WHERE " . $tab[0] . " = :" . $tab[0];
        echo $sql;
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = $this->formatSQLArray($objet);
        $pdoStatement->execute($values);
    }

    public function ajouter(AbstractDataObject $objet): bool
    {
            $columns = $this->getNomColonne();
            $placeholders = array_map(fn($col) => ":$col", $columns);
            $sql = "INSERT INTO " . $this->getNomTable() . " (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";
            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            return $pdoStatement->execute($this->formatSQLArray($objet));
    }

    public function ajouterSiNexistePas(AbstractDataObject $objet): bool
    {
        if ($this->getParClesPrimaires($this->getNomClesPrimaires()) == null) {
            return $this->ajouter($objet);
        }
        return false;
    }
}