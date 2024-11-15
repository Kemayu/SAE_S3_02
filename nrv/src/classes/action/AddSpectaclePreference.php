<?php

namespace iutnc\nrv\action;
use iutnc\nrv\repository\NrvRepository;
use iutnc\nrv\auth as auth;

class AddSpectaclePreference extends Action
{
    public function execute(): string
    {
        $html="";
        $idUser = NrvRepository::getInstance()->getIdUser(auth\AuthnProvider::getSignInUser());
        $arrayPreference = NrvRepository::getInstance()->tryPreferenceExist($idUser,$_POST['spectacle']);
        if (count($arrayPreference) === 0){
            NrvRepository::getInstance()->AddPreference($idUser,$_POST['spectacle']);
            $html = "Preference ajoutee";
        }else {
            $html = "Le spectacle est déjà dans la liste de préférence";
        }
        return $html;
    }
}