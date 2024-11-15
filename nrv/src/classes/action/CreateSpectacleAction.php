<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\AuthnProvider;
use iutnc\nrv\exception\AuthnException;
use iutnc\nrv\repository\NrvRepository;

class CreateSpectacleAction extends Action
{
    public function execute(): string
    {
        try{
            AuthnProvider::getSignInUser(); }
        catch(AuthnException $e){
            return "<h3>Pas authentifier</h3>";
        }

        if (AuthnProvider::getUserDroit() == 1) {
            return "<h3>Vous n'avez pas accès a la création de spectacle !</h3>";
        }elseif($this->http_method  === 'GET') {
            $html = <<<END
            <form method = "post" action = "?action=create-spectacle"><br>
               <label>Horraire du spectacle<input type="time" name="horraire"></label><br>
               <label>Durée<input type="number" name="duree"></label><br>
               <label>Tarifs<input type="number" name="tarifs"step="0.01"></label><br>
               <label>Extrait<input type="url" name="extrait"></label><br>
               <label>Titre<input type="text" name="titre"></label><br>
               <label>Description<input type="text" name="description"></label><br>
               <label>Image<input type="url" name="image"></label><br>
               <label>Style de musique<input type="text" name="style"></label><br>
                <label>Soirée </label>
               <select name="ID_SOIREE">
            END;
            $array = NrvRepository::getInstance()->getALlIdNameSoiree();
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
            $date =  NrvRepository::getInstance()->getSoireeById($_POST['ID_SOIREE'])['DATE_SOIREE'];
            NrvRepository::getInstance()->createSpectacle($date,$_POST['horraire'],$_POST['duree'],$_POST['tarifs'],$_POST['extrait'],$_POST['titre'],$_POST['description'],$_POST['image'],$_POST['style']);
            NrvRepository:: getInstance()->createLinkSoireeSpectacle(NrvRepository::getInstance()->getLastIdSpectacle(),$_POST['ID_SOIREE']);
            $html = "<h3>Spectacle créé</h3>";
            }
        return $html;
    }
}

