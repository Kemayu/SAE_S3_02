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
                <button type="submit">Créer</button>
            </form>
            END;

        } else {
            NrvRepository::getInstance()->createSpectacle($_POST['date'],$_POST['horraire'],$_POST['duree'],$_POST['tarifs'],$_POST['extrait'],$_POST['titre'],$_POST['description'],$_POST['image'],$_POST['style']);
            $html = "spectacle creer";
            }
        return $html;
    }
}

