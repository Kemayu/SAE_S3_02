<?php

namespace iutnc\nrv\action;

use iutnc\nrv\render as render;
use iutnc\nrv\auth as auth;
use iutnc\nrv\exception as exception;
use iutnc\nrv\objets as objets;
//Classe pour gerer l'affichage d'une playlist
class DisplaySoiree extends Action
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
            if((!isset($_GET['idSoiree']))){
                $html = <<<END
                <form method="get" action="?action=display-soiree">
                    <select name=idSoiree>
                END;
    
                $soirees = $repo->getAllIdNameSoiree();
                foreach($soirees as $s){
                    $html .= "<option value={$s['ID_SOIREE']}> {$s['NOM_SOIREE']}</option>";
                }
    
                $html .= <<<END
                    </select>
                    <input type="hidden" name="action" value="display-soiree">
                    <button type="submit">Afficher</button>
                    </form>
                END;
            }else{
                $soiree = $repo->getSoireeById($_GET["idSoiree"]);
                $html.="<div class = box>";
                $renderer = new render\RenderSoiree(new objets\Soiree($soiree["NOM_SOIREE"],$soiree["DATE_SOIREE"],$soiree["THEMATIQUE"],$soiree["HORAIRE_DEBUT"]));
                $html.= $renderer->render(1);
            }

                $html.="</div>";
                

        }

    return $html;
    }
}