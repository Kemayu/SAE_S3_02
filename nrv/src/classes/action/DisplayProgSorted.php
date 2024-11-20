<?php

namespace iutnc\nrv\action;

use iutnc\nrv\render as render;
use iutnc\nrv\auth as auth;
use iutnc\nrv\exception as exception;
use iutnc\nrv\objets as objets;
//Classe pour gerer l'affichage d'un programme triée par la date, le nom du lieu ou le style de musique
class DisplayProgSorted extends Action
{

    public function execute(): string
    {
        
        if((!isset($_GET['lst']))){
            $html = <<<END
            <form method="get" action="?action=display-sorted">
                <select name=lst>
            END;

            $html .= "<option value=DATE_SPECTACLE> Trier par journée</option>";
            $html .= "<option value=NOM_LIEU> Trier par lieu</option>";
            $html .= "<option value=STYLE_MUSIQUE> Trier par style de musique</option>";

            $html .= <<<END
                </select>
                <input type="hidden" name="action" value="display-sorted">
                <button type="submit">Afficher</button>
                </form>
            END;
        }else{
            $val = $_GET['lst'];
            $repo = \iutnc\nrv\repository\NrvRepository::getInstance();
            $prg = $repo->findProgramSorted($val);
            $i = 1;
            $html="<div class = 'box'>";
            forEach($prg as $spectacle){
                $renderer = new render\RenderSpectacle(new objets\Spectacle((int)$spectacle["ID_SPECTACLE"],$spectacle["TITRE_SPECTACLE"],$spectacle["DESCRIPTION_SPECTACLE"],$spectacle["IMAGE_SPECTACLE"],$spectacle["EXTRAIT_SPECTACLE"],$spectacle["DATE_SPECTACLE"],$spectacle["HORAIRE_SPECTACLE"],$spectacle["DUREE_SPECTACLE"],$spectacle["STYLE_MUSIQUE"],$spectacle["TARIF_SPECTACLE"]));
                $html.= $renderer->render(1);
            }
            $html.="</br></br></div>";
        }
        return $html;
    }
    
}