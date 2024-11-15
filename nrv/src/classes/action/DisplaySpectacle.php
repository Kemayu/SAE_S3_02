<?php

namespace iutnc\nrv\action;

use iutnc\nrv\render as render;
use iutnc\nrv\auth as auth;
use iutnc\nrv\exception as exception;
use iutnc\nrv\objets as objets;
//Classe pour gerer l'affichage d'une playlist
class DisplaySpectacle extends Action
{

    public function execute(): string
    {
        $html="";
        $connect = true;
        try{
            auth\AuthnProvider::getSignInUser();
        }catch(exception\AuthnException $e){
            $html = $e->getMEssage(); $connect = false;
        };
        if($connect){
            $repo = \iutnc\nrv\repository\NrvRepository::getInstance();
            $spectacle = $repo->getSpectacleById($_GET["id"]);
            $spectacles = $repo->getSpectacleSoiree($repo->getSoireeSpectacle((int)$spectacle["ID_SPECTACLE"]));
            $html.="<div class = box>";
            forEach($spectacles as $spec){
                $specs = $repo->getSpectacleById($spec["id_spectacle"]);
                $renderer = new render\RenderSpectacle(new objets\Spectacle((int)$specs["ID_SPECTACLE"],$specs["TITRE_SPECTACLE"],$specs["DESCRIPTION_SPECTACLE"],$specs["IMAGE_SPECTACLE"],$specs["EXTRAIT_SPECTACLE"],$specs["DATE_SPECTACLE"],$specs["HORAIRE_SPECTACLE"],$specs["DUREE_SPECTACLE"],$specs["STYLE_MUSIQUE"],$specs["TARIF_SPECTACLE"]));
                $html.= $renderer->render(3);
            }

            $html.="</div><div class = 'spectacle'>";
            

            $renderer = new render\RenderSpectacle(new objets\Spectacle((int)$spectacle["ID_SPECTACLE"],$spectacle["TITRE_SPECTACLE"],$spectacle["DESCRIPTION_SPECTACLE"],$spectacle["IMAGE_SPECTACLE"],$spectacle["EXTRAIT_SPECTACLE"],$spectacle["DATE_SPECTACLE"],$spectacle["HORAIRE_SPECTACLE"],$spectacle["DUREE_SPECTACLE"],$spectacle["STYLE_MUSIQUE"],$spectacle["TARIF_SPECTACLE"]));
            $html.= $renderer->render(2);
            $html.="</br></br></div>";
        }
    return $html;
    }
}