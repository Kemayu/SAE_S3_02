<?php

namespace iutnc\nrv\action;
use iutnc\nrv\repository\NrvRepository;

class AddSpectaclePreference extends Action
{
    public function execute(): string
    {
        if ($this->http_method === 'GET') {
            $html = <<<END
            <form method="POST" action="?action=add-preference">
            <label for="name">idSpec :</label>            
            <input type="text" name="name" required><br>
            
            END;
            $array = NrvRepository::getInstance()->findProgramSorted("DATE_SPECTACLE");
            // Boucle pour générer chaque option de la liste déroulante

            foreach ($array as $option) {
                $text = $option['ID_SPECTACLE']. " " . $option['TITRE_SPECTACLE'];
                $html .= "<option value='{$option['ID_SPECTACLE']}'>{$text}</option>";
            }
            $html.= <<<END
            </select>
            <input type="hidden" name="action" value="un-spectacle">       
            <button type="submit">Ajouter dans la liste de preference</button>
            </form>
           END;

        } else {
            NrvRepository::getInstance()->AddPreference($_GET['ID_UTILISATEUR'],$_POST['name']);
            $html = "Preference ajoutee";

        }
        return $html;
    }
}