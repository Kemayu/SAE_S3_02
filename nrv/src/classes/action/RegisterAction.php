<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth as auth;
use iutnc\nrv\exception as exception;

//Classe pour gerer l'inscription
class RegisterAction extends Action
{

    public function execute(): string
    {
        if($this->http_method  === 'GET'){
            $html = <<<END
            <form method = "post" action = "?action=register">
                <label>Nom d'Utilisateur <input class=in type="text" name="usr" placeholder="Nom d'Utilisateur"></label>
                <label>Numero de telephone <input class=in type="text" name="tel" placeholder="06 ..."></label>
                <label>Email <input class=in type="text" name="email" placeholder="email"></label>
                <label>Mot de passe <input class=in type="password" name="mdp" placeholder="mot de passe"></label>
                <button type="submit">Créer</button>
            </form>
            END;

        }else{
            try{
            auth\AuthnProvider::register($_POST['usr'],$_POST['tel'],$_POST['email'],$_POST['mdp']);
            $html = "<h3>votre compte à été créé</h3></div>";
            }catch(exception\AuthnException $e){
                $html = $e->getMessage();
            }


        }
         return $html;
        
    }
}