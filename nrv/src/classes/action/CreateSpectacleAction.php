<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\NrvRepository;

class CreateSpectacleAction extends Action
{
    public function execute(): string
    {
        if ($this->http_method  === 'GET') {
            $html = <<<END
            <form method = "post" action = "?action=create-spectacle"><br>
               <label>Date du spectacle<input type="date" name="date"></label><br>
               <label>Horraire du spectacle<input type="text" name="horraire"></label><br>
               <label>Durée<input type="number" name="duree"></label><br>
               <label>Tarifs<input type="number" name="tarifs"></label><br>
               <label>Extrait<input type="text" name="extrait"></label><br>
               <label>Titre<input type="text" name="titre"></label><br>
               <label>Description<input type="text" name="description"></label><br>
               <label>Image<input type="text" name="image"></label><br>
               <label>Style de musique<input type="text" name="style"></label><br>
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
            <input type="hidden" name="action" value="une-soiree">               
            <button type="submit">Créer</button>
            </form>
            END;

        } else {
            NrvRepository::getInstance()->createSpectacle($_POST['date'],$_POST['horraire'],$_POST['duree'],$_POST['tarifs'],$_POST['extrait'],$_POST['titre'],$_POST['description'],$_POST['image'],$_POST['style']);
            NrvRepository::getInstance()->createLinkSoireeSpectacle(NrvRepository::getInstance()->getIDSpectacle(),$_POST['ID_SOIREE']);
            $html = "spectacle creer";
            }
        return $html;
    }
}

