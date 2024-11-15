<?php

namespace iutnc\nrv\action;


use iutnc\nrv\auth as auth;

//Classe pour gerer la deconnection
class DisconnectAction extends Action
{

    public function execute(): string
    {       
        if (isset( $_SESSION['user'])) {
            session_destroy();
            return "<h3>vous avez été déconnecté</h3>";
        } else {
            return "<h3>Vous n'êtes pas connecté</h3>";
        }
    }
}