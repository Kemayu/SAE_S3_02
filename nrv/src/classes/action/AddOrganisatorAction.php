<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\AuthnProvider;
use iutnc\nrv\exception\AuthnException;
use iutnc\nrv\repository\NrvRepository;

class AddOrganisatorAction extends Action
{
    public function execute(): string
    {
        try {
            AuthnProvider::getSignInUser();
        } catch (AuthnException $e) {
            return "<h3>Pas authentifier</h3>";
        }

        if (AuthnProvider::getUserDroit() == 1 || AuthnProvider::getUserDroit() == 15) {
            return "<h3>Vous n'avez pas accès a l'ajout d'organisateur !</h3>";
        }

        else if ($this->http_method === 'GET') {

            $html = <<<END
            <form method = "post" action = "?action=add-organisator"><br>
               <select name="ID_UTILISATEUR">
            END;
            $array = NrvRepository::getInstance()->getAllIdNomUserNotAdmin();
            // Boucle pour générer chaque option de la liste déroulante

            foreach ($array as $option) {
                    $text = $option['ID_UTILISATEUR'] . " " . $option['NOM_UTILISATEUR'];
                    $html .= "<option value='{$option['ID_UTILISATEUR']}'>{$text}</option>";
            }
            $html .= <<<END
            </select>
            <input type="hidden" name="action" value="un-utilisateur">               
            <button type="submit">Ajouter</button>
            </form>
            END;

        } else {
            NrvRepository::getInstance()->updateUserRole($_POST['ID_UTILISATEUR']);
            $html = "Organisteur ajouté";
        }
        return $html;
    }
}