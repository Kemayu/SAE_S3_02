<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\AuthnProvider;
use iutnc\nrv\exception\AuthnException;
use iutnc\nrv\repository\NrvRepository;

class ModifySoireeAction extends Action
{
    public function execute(): string
    {
        try{
            AuthnProvider::getSignInUser(); }
        catch(AuthnException $e){
            return "<h3>Pas authentifier</h3>";
        }

        if (AuthnProvider::getUserDroit() == 1) {
            return "<h3>Vous n'avez pas accès a la modification de soirée !</h3>";
        }
        $selectedSoireeId = $_GET['ID_SOIREE'] ?? null;


        $soirees = NrvRepository::getInstance()->getALlIdNameSoiree();

        $soiree = $selectedSoireeId ?
            NrvRepository::getInstance()->getSoireeById($selectedSoireeId) : null;


        $html = <<<END
            <form method="GET" action="">
            <input type="hidden" name="action" value="modify-soiree">
            <label for="name">Nom de la soirée:</label>  
            <select name="ID_SOIREE" onchange="this.form.submit()">
                <option value="">-- Sélectionnez une soirée --</option>
        END;


        foreach ($soirees as $option) {
            $isSelected = $option['ID_SOIREE'] == $selectedSoireeId ? "selected" : "";
            $text = $option['ID_SOIREE'] . " " . $option['NOM_SOIREE'];
            $html .= "<option value='{$option['ID_SOIREE']}' {$isSelected}>{$text}</option>";
        }

        $html .= <<<END
            </select><br>
        </form>
        END;

        if ($soiree) {
            $html .= <<<END
                <form method="POST" action="?action=modify-soiree">
                <input type="hidden" name="ID_SOIREE" value="{$soiree['ID_SOIREE']}">

                <label>Nom
                    <input type="text" name="NOM_SOIREE" value="{$soiree['NOM_SOIREE']}">
                </label><br>

                <label>Date
                    <input type="date" name="DATE_SOIREE" value="{$soiree['DATE_SOIREE']}">
                </label><br>

                <label>Thématique
                    <input type="text" name="THEMATIQUE" value="{$soiree['THEMATIQUE']}">
                </label><br>

                <label>Horaire
                    <input type="text" name="HORAIRE_DEBUT" value="{$soiree['HORAIRE_DEBUT']}">
                </label><br>
                <label>Lieu</label>  
                <select name="ID_LIEU"">
                
                END;

            $lieux = NrvRepository::getInstance()->getIdLieu();
            foreach ($lieux as $lieu) {
                if ($soiree['ID_LIEU'] === $lieu['ID_LIEU']){
                    $text = $lieu['ID_LIEU'] . " " . $lieu['NOM_LIEU'];
                    $html .= "<option value='{$lieu['ID_LIEU']}'>{$text}</option>";
                    }
            }
            foreach ($lieux as $lieu) {
                if (!($soiree['ID_LIEU'] === $lieu['ID_LIEU'])){
                    $text = $lieu['ID_LIEU'] . " " . $lieu['NOM_LIEU'];
                    $html .= "<option value='{$lieu['ID_LIEU']}'>{$text}</option>";
                }
            }

            $html.=
                <<<END
                </select><br>
                <button type="submit">Modifier</button>
            </form>
            END;
        }


        if ($this->http_method === 'POST') {
            NrvRepository::getInstance()->updateSoiree(
                $_POST['ID_SOIREE'],
                $_POST['NOM_SOIREE'],
                $_POST['DATE_SOIREE'],
                $_POST['THEMATIQUE'],
                $_POST['HORAIRE_DEBUT'],
                $_POST['ID_LIEU'],

            );
            $html = "Soirée modifiée avec succès";
        }

        return $html;
    }


}