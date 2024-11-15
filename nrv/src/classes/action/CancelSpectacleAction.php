<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\AuthnProvider;
use iutnc\nrv\exception\AuthnException;
use iutnc\nrv\repository\NrvRepository;

class CancelSpectacleAction extends Action
{
    public function execute(): string
    {
        try {
            AuthnProvider::getSignInUser();
        } catch (AuthnException $e) {
            return "<h3>Pas authentifier</h3>";
        }

        if (AuthnProvider::getUserDroit() == 1) {
            return "<h3>Vous n'avez pas accès a l'annulation de spectacle !</h3>";
        }
        if (NrvRepository::getInstance()->getNbSpectaclePasAnnule() === 0) {
            return "Tous les spectacles sont annulés";
        } else if ($this->http_method === 'GET') {

            $html = <<<END
            <form method = "post" action = "?action=cancel-spectacle"><br>
               <select name="ID_SPECTACLE">
            END;
            $array = NrvRepository::getInstance()->getALlIdTitreDescriptionSpectacle();
            // Boucle pour générer chaque option de la liste déroulante

            foreach ($array as $option) {
                if (!($option['DESCRIPTION_SPECTACLE'] === 'Annulé')) {
                    $text = $option['ID_SPECTACLE'] . " " . $option['TITRE_SPECTACLE'];
                    $html .= "<option value='{$option['ID_SPECTACLE']}'>{$text}</option>";
                }
            }
            $html .= <<<END
            </select>
            <input type="hidden" name="action" value="un-spectacle">               
            <button type="submit">Annuler Spectacle</button>
            </form>
            END;

        } else {
            $message = "Annulé";
            NrvRepository::getInstance()->setStatusSpectacle($_POST['ID_SPECTACLE'], $message);
            $html = "<h3>Spectacle $message</h3>";
        }
        return $html;
    }
}