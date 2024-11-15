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
                <label>Email <input type="email" name="email" placeholder="email"></label></br>
                <label>Mot de passe <input type="password" name="mdp" placeholder="mot de passe"></label>
                <button type="submit">connexion</button>
            </form>
            END;

        }else{
            try {
                auth\AuthnProvider::signin($_POST['email'],$_POST['mdp']);
                $html = "<div>vous êtes connecté, bienvenue ".unserialize($_SESSION['user'])->email."</div>";
            } catch(exception\AuthnException $e){
                $html = "<h3>erreur lors de la connexion</h3>";
            }

        }
         return $html;
        
    }
}