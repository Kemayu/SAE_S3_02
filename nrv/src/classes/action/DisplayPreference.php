<?php

namespace iutnc\nrv\action;

use iutnc\nrv\render as render;
use iutnc\nrv\auth as auth;
use iutnc\nrv\exception as exception;
use iutnc\nrv\objets as objets;
//Classe pour gerer l'affichage d'une playlist
class DisplayPreference extends Action
{

    public function execute(): string
    {
        $connect = true;
        try{
            $IdUser = auth\AuthnProvider::getSignInUser();
        }catch(exception\AuthnException $e){
            $html = $e->getMEssage(); $connect = false;
        };
        if($connect){
            $repo = \iutnc\nrv\repository\NrvRepository::getInstance();
            $html = "";
            $spect = $repo->getPreference($repo->getIdUser($IdUser));
            $html.="<div class = 'box'>";
            forEach($spect as $spec){
                $spectacle = $repo->getSpectacleById($spec['ID_SPECTACLE']);
                $renderer = new render\RenderSpectacle(new objets\Spectacle((int)$spectacle["ID_SPECTACLE"],$spectacle["TITRE_SPECTACLE"],$spectacle["DESCRIPTION_SPECTACLE"],$spectacle["IMAGE_SPECTACLE"],$spectacle["EXTRAIT_SPECTACLE"],$spectacle["DATE_SPECTACLE"],$spectacle["HORAIRE_SPECTACLE"],$spectacle["DUREE_SPECTACLE"],$spectacle["STYLE_MUSIQUE"],$spectacle["TARIF_SPECTACLE"]));
                $html.= $renderer->render(1);
                $html.="</br></br>";
            }
            $html.="</div>";
            if (count($spect) === 0){
                $html.= "pas de spectacle dans votre liste";
            }
        }
        return $html;
    }
}