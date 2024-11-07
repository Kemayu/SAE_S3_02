<?php
namespace iutnc\nrv\auth;
//Classe gerant les droits.
class Authz{
    //Fonction qui verifie le role de l'utilisateur
    public static function checkRole() : bool{
        return true;
    }
    //Fonction qui vérifie les droits de l'utilisateur.
    //Elle dirige vers une fonction pour voir toutes les playlist et une fonction pour voir seulement les siennes
    public static function checkOwnerPlaylists(): array{
            return [];
    }
}