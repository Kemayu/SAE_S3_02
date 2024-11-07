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
            return "vous avez été déconnecté";
        } else {
            return "Vous n'êtes pas connecté";
        }
    }
}