<?php

namespace iutnc\nrv\action;

//Classe pour gerer l'action par defaut
class DefaultAction extends Action
{

    public function execute(): string
    {
        return "<h3>Bienvenue !</h3>";
    }
}