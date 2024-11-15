<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\AuthnProvider;
use iutnc\nrv\exception\AuthnException;
use iutnc\nrv\repository\NrvRepository;

class DeleteSoireeAction extends Action
{
    public function execute(): string
    {
        try{
            AuthnProvider::getSignInUser(); }
        catch(AuthnException $e){
            return "<h3>Pas authentifier</h3>";
        }

        if (AuthnProvider::getUserDroit() == 1) {
            return "<h3>Vous n'avez pas accès a la suppression de la soirée !</h3>";
        } elseif($this->http_method  === 'GET') {
            $html = <<<END
            <form method = "post" action = "?action=delete-soiree"><br>
               
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
            <button type="submit">Supprimé</button>
            </form>
            END;

        } else {
            NrvRepository::getInstance()->deleteSoiree($_POST['ID_SOIREE']);
            NrvRepository::getInstance()->deleteSoireeSpectacle( NrvRepository::getInstance()->getIDSpectacleFromSpectacleSoiree($_POST['ID_SOIREE']), $_POST['ID_SOIREE']);
            $html = "Soirée supprimé";
        }
        return $html;
    }

}