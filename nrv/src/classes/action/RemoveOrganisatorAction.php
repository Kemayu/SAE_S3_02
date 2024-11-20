<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\AuthnProvider;
use iutnc\nrv\exception\AuthnException;
use iutnc\nrv\repository\NrvRepository;

//Classe pour gerer la suppression d'un organisateur
class RemoveOrganisatorAction extends Action
{

    public function execute(): string
    {
        try {
            AuthnProvider::getSignInUser();

        } catch (AuthnException $e) {
            return "<h3>Vous n'êtes pas authentifié</h3>";
        }

        if (AuthnProvider::getUserDroit() == 1 || AuthnProvider::getUserDroit() == 15) {
            return "<h3>Vous n'avez pas accès à la suppression d'organisateurs !</h3>";
        }
        else if ($this->http_method === 'GET') {

            $html = <<<END
            <form method = "post" action = "?action=remove-organisator"><br>
               <select name="ID_UTILISATEUR">
            END;
            $array = NrvRepository::getInstance()->getAllIdNomUserOrganisator();
            // Boucle pour générer chaque option de la liste déroulante

            foreach ($array as $option) {
                $text = $option['ID_UTILISATEUR'] . " " . $option['NOM_UTILISATEUR'];
                $html .= "<option value='{$option['ID_UTILISATEUR']}'>{$text}</option>";
            }
            $html .= <<<END
            </select>
            <input type="hidden" name="action" value="un-utilisateur">               
            <button type="submit">Retirer</button>
            </form>
            END;

        } else {
            NrvRepository::getInstance()->setUserRole($_POST['ID_UTILISATEUR'], 1);
            $html = "<h3>Organisteur retiré</h3>";
        }
        return $html;
    }


}