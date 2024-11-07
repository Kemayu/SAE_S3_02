<?php

namespace iutnc\nrv\action;

use iutnc\nrv\render as render;
use iutnc\nrv\auth as auth;
use iutnc\nrv\exception as exception;
//Classe pour gerer l'affichage d'une playlist
class DisplayProgSorted extends Action
{

    public function execute(): string
    {
        $val="rien";
        if (isset($_GET['DATE_SPECTACLE'])) {
            $val="DATE_SPECTACLE";
        } else if (isset($_GET['NOM_LIEU'])) {
            $val="NOM_LIEU";
        } else if (isset($_GET['STYLE_MUSIQUE'])) {
            $val="STYLE_MUSIQUE";
        }
        if(($this->http_method  === 'GET') && ($val=="rien")){
            $connect = true;
            try{
                auth\AuthnProvider::getSignInUser();
            }catch(exception\AuthnException $e){
                $html = $e->getMEssage(); $connect = false;
            };
            if($connect){
                $html = <<<END
                <form method="get" action="?action=DisplaySorted">
                    <select name={$val}>
                END;

                $html .= "<option value=DATE_SPECTACLE> {Trier par journée}</option>";
                $html .= "<option value=NOM_LIEU> {Trier par lieu}</option>";
                $html .= "<option value=STYLE_MUSIQUE> {Trier par style de musique}</option>";

                $html .= <<<END
                    </select>
                    <input type="hidden" name="action" value="une-playlist">
                    <button type="submit">Afficher</button>
                    </form>
                END;
            }
        }else{
            $repo = \iutnc\nrv\repository\NrvRepository::getInstance();
            $prg = $repo->findProgramSorted($val);
            $html = "<div> voici votre Programme : </div>";
            $html.="</br></br>";
            $renderer = new render\RenderSpectacle($prg);
            $html.= $renderer->render(1);
            $html.="</br></br>";
        }
        return $html;
    }
}