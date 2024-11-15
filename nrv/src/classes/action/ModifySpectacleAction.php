<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\AuthnProvider;
use iutnc\nrv\exception\AuthnException;
use iutnc\nrv\repository\NrvRepository;

class ModifySpectacleAction extends Action
{
    public function execute(): string
    {
        try{
            AuthnProvider::getSignInUser(); }
        catch(AuthnException $e){
            return "<h3>Pas authentifier</h3>";
        }

        if (AuthnProvider::getUserDroit() == 1) {
            return "<h3>Vous n'avez pas accès a la modification de spectacle !</h3>";
        }
        // Récupérer l'ID du spectacle sélectionné dans la requête GET (si disponible)
        $selectedSpectacleId = $_GET['ID_SPECTACLE'] ?? null;

        // Charger la liste des spectacles pour le menu déroulant
        $spectacles = NrvRepository::getInstance()->getALlIdTitreDescriptionSpectacle();

        // Charger les détails du spectacle sélectionné (si un ID est fourni)
        $spectacle = $selectedSpectacleId ?
            NrvRepository::getInstance()->getSpectacleById($selectedSpectacleId) : null;

        // Formulaire pour la sélection du spectacle et rechargement des détails
        $html = <<<END
        <form method="GET" action="">
            <input type="hidden" name="action" value="modify-spectacle">
            <label for="name">Titre du spectacle:</label>  
            <select name="ID_SPECTACLE" onchange="this.form.submit()">
                <option value="">-- Sélectionnez un spectacle --</option>
        END;

        // Générer les options du menu déroulant avec l'ID sélectionné par défaut
        foreach ($spectacles as $option) {
            $isSelected = $option['ID_SPECTACLE'] == $selectedSpectacleId ? "selected" : "";
            $text = $option['ID_SPECTACLE'] . " " . $option['TITRE_SPECTACLE'];
            $html .= "<option value='{$option['ID_SPECTACLE']}' {$isSelected}>{$text}</option>";
        }

        $html .= <<<END
            </select><br>
        </form>
        END;


        if ($spectacle) {
            $html .= <<<END
            <form method="POST" action="?action=modify-spectacle">
                <input type="hidden" name="ID_SPECTACLE" value="{$spectacle['ID_SPECTACLE']}">

                <label>Horaire du spectacle
                    <input type="time" name="horaire" value="{$spectacle['HORAIRE_SPECTACLE']}">
                </label><br>

                <label>Durée
                    <input type="number" name="duree" value="{$spectacle['DUREE_SPECTACLE']}">
                </label><br>

                <label>Tarifs
                    <input type="number" name="tarifs" value="{$spectacle['TARIF_SPECTACLE']}">
                </label><br>

                <label>Extrait
                    <input type="url" name="extrait" value="{$spectacle['EXTRAIT_SPECTACLE']}">
                </label><br>

                <label>Titre
                    <input type="text" name="titre" value="{$spectacle['TITRE_SPECTACLE']}">
                </label><br>

                <label>Description
                    <input type="text" name="description" value="{$spectacle['DESCRIPTION_SPECTACLE']}">
                </label><br>

                <label>Image
                    <input type="url" name="image" value="{$spectacle['IMAGE_SPECTACLE']}">
                </label><br>

                <label>Style de musique
                    <input type="text" name="style" value="{$spectacle['STYLE_MUSIQUE']}">
                </label><br>

                <button type="submit">Modifier</button>
            </form>
            END;
        }

        // Si méthode POST, mettre à jour les informations du spectacle
        if ($this->http_method === 'POST') {
            NrvRepository::getInstance()->updateSpectacle(
                $_POST['ID_SPECTACLE'],
                $_POST['horaire'],
                $_POST['duree'],
                $_POST['tarifs'],
                $_POST['extrait'],
                $_POST['titre'],
                $_POST['description'],
                $_POST['image'],
                $_POST['style']
            );
            $html = "<h3>Spectacle modifié avec succès</h3>";
        }

        return $html;
    }
}
