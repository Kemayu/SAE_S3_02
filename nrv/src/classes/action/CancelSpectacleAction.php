<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\NrvRepository;

class CancelSpectacleAction extends Action
{
    public function execute(): string
    {
        if ($this->http_method  === 'GET') {
            $html = <<<END
            <form method = "post" action = "?action=cancel-spectacle"><br>
               <select name="ID_SOIREE">
            END;
            $array = NrvRepository::getInstance()->getIDSoiree();
            // Boucle pour générer chaque option de la liste déroulante

            foreach ($array as $option) {
                $text = $option['ID_SOIREE']. " " . $option['NOM_SOIREE'];
                $html .= "<option value='{$option['ID_SOIREE']}'>{$text}</option>";
            }
            $html.= <<<END
            </select>
            <input type="hidden" name="action" value="un-spectacle">               
            <button type="submit">Annulé Spectacle</button>
            </form>
            END;

        } else {
            NrvRepository::getInstance()->StatusSpectacle($_POST['ID_SOIREE']);
            $html = "Spectacle Annulé";
        }
        return $html;
    }
}