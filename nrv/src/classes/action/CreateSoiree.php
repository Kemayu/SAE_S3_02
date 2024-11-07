<?php

namespace iutnc\nrv\action;



class CreateSoiree extends Action
{
    public function execute(): string
    {
        if ($this->http_method === 'GET') {
            $html = <<<END
            <form method="POST" action="?action=add-soiree">
            <label for="name">Nom de la Soirée :</label>            
            <input type="text" name="name" required><br>
            <label for="date">Date de la Soirée :</label>
            <input type="text" name="date" required><br>
            <label for="thematique">Thématique de la Soirée :</label>
            <input type="text" name="thematique" required><br>           
            <label for="horraire">Horraire de la Soirée</label>
            <input type="text" name="horraire" required><br>
            <button type="submit">Créer la Soirée</button>
            </form>
            END;

        } else {
            $html = "Soirée Crée";


        }
        return $html;
    }
}