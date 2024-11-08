<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\NrvRepository;

class ModifySOIAction extends Action
{
    public function execute(): string
    {
        if ($this->http_method === 'GET') {
            $html = <<<END
                <form method="POST" action="?action=modify-soi">
                <select name="id_soiree">
                END;
            $array = NrvRepository::getInstance()->getIDSoiree();
            // Boucle pour générer chaque option de la liste déroulante

            foreach ($array as $option) {
                $text = $option['ID_SOIREE']. " " . $option['NOM_SOIREE'];
                $html .= "<option value='{$option['ID_SOIREE']}'>{$text}</option>";
            }
            $html.= <<<END
            </select>
            $html.= <<<END
            
            <label for="name">Nom de la Soirée :</label>            
            <input type="text" name="name" required><br>
            <label for="date">Date de la Soirée :</label>
            <input type="date" name="date" required><br>
            <label for="thematique">Thématique de la Soirée :</label>
            <input type="text" name="thematique" required><br>           
            <label for="horraire">Horraire de la Soirée</label>
            <input type="text" name="horraire" required><br>
            <select name="idlieu">
            END;
            $array = NrvRepository::getInstance()->getIdLieu();
            // Boucle pour générer chaque option de la liste déroulante

            foreach ($array as $option) {
                $text = $option['ID_LIEU']. " " . $option['NOM_LIEU'];
                $html .= "<option value='{$option['ID_LIEU']}'>{$text}</option>";
            }
            $html.= <<<END
            </select>
            <input type="hidden" name="action" value="un-lieu">       
            <button type="submit">Modifier la Soirée</button>
            </form>
           END;

        } else {
            NrvRepository::getInstance()->ModifySoiree($_POST['id_soiree'],$_POST['name'],$_POST['date'], $_POST['thematique'], $_POST['horraire'],$_POST['idlieu']);
            $html = "Soirée Modifier";

        }
        return $html;
    }
}