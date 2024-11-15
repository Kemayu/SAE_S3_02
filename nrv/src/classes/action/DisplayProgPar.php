<?php

namespace iutnc\nrv\action;

use iutnc\nrv\render as render;
use iutnc\nrv\auth as auth;
use iutnc\nrv\exception as exception;
use iutnc\nrv\objets as objets;
//Classe pour gerer l'affichage d'une playlist
class DisplayProgPar extends Action
{

    public function execute(): string
    {
        
        if(!isset($_GET['lst']) and !isset($_GET['date']) and !isset($_GET['lieu'])){
            $connect = true;
            try{
                auth\AuthnProvider::getSignInUser();
            }catch(exception\AuthnException $e){
                $html = $e->getMEssage(); $connect = false;
            };
            if($connect){
                $html = <<<END
                <form method="get" action="?action=display-par">
                    <select name=lst>
                END;

                $html .= "<option value=DATE_SPECTACLE> par journée</option>";
                $html .= "<option value=NOM_LIEU> par lieu</option>";
                $html .= "<option value=STYLE_MUSIQUE> par style de musique</option>";

                $html .= <<<END
                    </select>
                    <input type="hidden" name="action" value="display-par">
                    <button type="submit">Afficher</button>
                    </form>
                END;
            }
        }else{
            $val = $_GET['lst'];
            $repo = \iutnc\nrv\repository\NrvRepository::getInstance();
            $array = [];
            $html = "";
            switch ($val){
                case "DATE_SPECTACLE" :
                    if(!isset($_GET['date'])){
                        $html = <<<END
                        <form method="get" action="?action=display-par">
                        <input type="hidden" name="lst" value=$val>
                        <label for="date">Date de la journée :</label>
                        <input type="date" name="date" required><br>
                        </select>
                        <input type="hidden" name="action" value="display-par">
                        <button type="submit">Afficher</button>
                        </form>
                        END;
                    }else{
                        $array = $repo-> findProgramPar($val,$_GET['date']);
                    }
                    break;
                case "NOM_LIEU" :
                    if(!isset($_GET['lieu'])){
                        $html = <<<END
                        <form method="get" action="?action=display-par">
                        <input type="hidden" name="lst" value=$val>
                        <select name=lieu>
                    END;

                    $lieux = $repo->recupAllLieux();
                    forEach($lieux as $lieu){
                        $nomLieu = rawurlencode($lieu['nom_lieu']);
                        $html .= "<option value={$nomLieu}> {$lieu['nom_lieu']}</option>";
                    }

                    $html .= <<<END
                        </select>
                        <input type="hidden" name="action" value="display-par">
                        <button type="submit">Afficher</button>
                        </form>
                    END;
                }else{
                    $lieu = urldecode($_GET['lieu']);
                    $array = $repo-> findProgramPar($val,$lieu);
                }
                break;
                case "STYLE_MUSIQUE" :
                    if(!isset($_GET['style'])){
                        $html = <<<END
                        <form method="get" action="?action=display-par">
                        <input type="hidden" name="lst" value=$val>
                        <select name=style>
                    END;

                    $styles = $repo->recupAllStyles();
                    forEach($styles as $style){
                        $html .= "<option value={$style["style_musique"]}> {$style["style_musique"]}</option>";
                    }

                    $html .= <<<END
                        </select>
                        <input type="hidden" name="action" value="display-par">
                        <button type="submit">Afficher</button>
                        </form>
                    END;
                }else{
                    $array = $repo-> findProgramPar($val,$_GET["style"]);
                }
                break;
            }
            $html.="<div class = 'box'>";
            forEach($array as $spectacle){
                $renderer = new render\RenderSpectacle(new objets\Spectacle((int)$spectacle["ID_SPECTACLE"],$spectacle["TITRE_SPECTACLE"],$spectacle["DESCRIPTION_SPECTACLE"],$spectacle["IMAGE_SPECTACLE"],$spectacle["EXTRAIT_SPECTACLE"],$spectacle["DATE_SPECTACLE"],$spectacle["HORAIRE_SPECTACLE"],$spectacle["DUREE_SPECTACLE"],$spectacle["STYLE_MUSIQUE"],$spectacle["TARIF_SPECTACLE"]));
                $html.= $renderer->render(1);
                $html.="</br></br>";
            }
            $html.="</div>";
            if (count($array) === 0 and isset($_GET["date"])){
                $html.= "<div class = 'box'>pas de spectacle à cette date..</div>";
            }
            if (count($array) === 0 and isset($_GET["lieu"])){
                $html.= "<div class = 'box'>pas de spectacle dans ce lieu..</div>";
            }
        }
        return $html;
    }
}