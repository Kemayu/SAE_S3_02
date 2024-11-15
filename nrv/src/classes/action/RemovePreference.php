<?php

namespace iutnc\nrv\action;
use iutnc\nrv\repository\NrvRepository;
use iutnc\nrv\auth as auth;

class RemovePreference extends Action
{
    public function execute(): string
    {
        $html="";
        $idUser = NrvRepository::getInstance()->getIdUser(auth\AuthnProvider::getSignInUser());
        $arrayPreference = NrvRepository::getInstance()->tryPreferenceExist($idUser,$_POST['spectacle']);
        if (count($arrayPreference) === 1){
            NrvRepository::getInstance()->RemovePreference($idUser,$_POST['spectacle']);
            $html = "Préference supprimée";
        }else {
            $html = "Le spectacle n'est pas dans la liste de préférence";
        }
        return $html;
    }
}