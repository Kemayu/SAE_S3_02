<?php

namespace iutnc\nrv\action;

use iutnc\nrv\render as render;
use iutnc\nrv\auth as auth;
use iutnc\nrv\exception as exception;
use iutnc\nrv\objets as objets;
//Classe pour gerer l'affichage d'une playlist
class DisplayProgSorted extends Action
{

    public function execute(): string
    {
        
        if((!isset($_GET['lst']))){
            $connect = true;
            try{
                auth\AuthnProvider::getSignInUser();
            }catch(exception\AuthnException $e){
                $html = $e->getMEssage(); $connect = false;
            };
            if($connect){
                $html = <<<END
                <form method="get" action="?action=Display-Sorted">
                    <select name=lst>
                END;

                $html .= "<option value=DATE_SPECTACLE> Trier par journée</option>";
                $html .= "<option value=NOM_LIEU> Trier par lieu</option>";
                $html .= "<option value=STYLE_MUSIQUE> Trier par style de musique</option>";

                $html .= <<<END
                    </select>
                    <input type="hidden" name="action" value="Display-Sorted">
                    <button type="submit">Afficher</button>
                    </form>
                END;
            }
        }else{
            $val = $_GET['lst'];
            $repo = \iutnc\nrv\repository\NrvRepository::getInstance();
            $prg = $repo->findProgramSorted($val);
            $html = "<p> voici votre Programme : </p>";
            $html.="</br></br>";
            $i = 1;

            forEach($prg as $spectacle){
                $renderer = new render\RenderSpectacle(new objets\Spectacle($spectacle["TITRE_SPECTACLE"],$spectacle["DESCRIPTION_SPECTACLE"],$spectacle["IMAGE_SPECTACLE"],$spectacle["EXTRAIT_SPECTACLE"],$spectacle["DATE_SPECTACLE"],$spectacle["HORAIRE_SPECTACLE"],$spectacle["DUREE_SPECTACLE"],$spectacle["STYLE_MUSIQUE"],$spectacle["TARIF_SPECTACLE"]));
                $html.= $renderer->render(1);
                $html.="</br></br>";
            }
            $html.="</br></br>";
        }
        return $html;
    }
}