<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth as auth;
use iutnc\nrv\exception as exception;

//Classe pour gerer la connection
class SignInAction extends Action
{

    public function execute(): string
    {
        if($this->http_method  === 'GET'){
            $html = <<<END
            <form method = "post" action = "?action=signin">
                <label>Email <input type="text" name="email" placeholder="email"></label>
                <label>Mot de passe <input type="text" name="mdp" placeholder="mot de passe"></label>
                <button type="submit">connexion</button>
            </form>
            END;

        }else{
            try {
                auth\AuthnProvider::signin($_POST['email'],$_POST['mdp']);
                $html = "<div>vous êtes connecté, bienvenue ".unserialize($_SESSION['user'])->email."</div>";
            } catch(exception\AuthnException $e){
                $html = "erreur lors de la connexion";
            }


        }
         return $html;
        
    }
}