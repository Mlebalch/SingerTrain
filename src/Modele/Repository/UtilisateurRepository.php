<?php

namespace App\Modele\Repository;
use App\Modele\DataObject\AbstractDataObject;
use App\Modele\DataObject\Utilisateur;


class UtilisateurRepository extends AbstractRepository
{


    protected function getTableName(): string
    {
        return 'Utilisateur';
    }

    protected function getPrimaryKeyNames(): array
    {
        return ['login'];
    }

    protected function getColumnNames(): array
    {
        return ['login',  'mdp', 'email', 'role'];
    }

    protected function formatSQLArray(AbstractDataObject $objet): array
    {

        return array(
            'login' => $objet->getLogin(),
            'mdp' => $objet->getMdp(),
            'email' => $objet->getEmail(),
            'role' => $objet->getRole()
        );
    }

    protected function constructFromSQLArray(array $objetFormatTableau): AbstractDataObject
    {
        return new Utilisateur(
            $objetFormatTableau['login'],
            $objetFormatTableau['mdp'],
            $objetFormatTableau['email'],
            $objetFormatTableau['role']
        );
    }

}