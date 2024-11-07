<?php
declare(strict_types=1);

namespace iutnc\nrv\dispatch;

use iutnc\nrv\action as act;

//Classe dispatcher permettant de gerer les interactions avec le site
class Dispatcher
{
    //Attribut qui contient l'action qui vient d'etre realisee
    private ?string $action = null;

    //initialisation de l'action
    function __construct()
    {
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'default';
    }

    //fonction permettant d'executer l'action
    //Pour chaque action, on creer un objet de l'action correspondante et on utilise sa methode execute()
    public function run(): void
    {
        $html = '';
        switch ($this->action) {
            case 'default':
                $action = new act\DefaultAction();
                $html = $action->execute();
                break;
            case 'register' : 
                $action = new act\RegisterAction();
                $html = $action->execute();
                break;
            case 'signin' : 
                $action = new act\SignInAction();
                $html = $action->execute();
                break;
            case 'disconnect':
                $action = new act\DisconnectAction();
                $html = $action->execute();
                break;
        }
        $this->renderPage($html);
    }

    //fonction permettant d'afficher la page web
    private function renderPage(string $html): void
    {
        echo <<<HEAD
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>NRV</title>
</head>
<body>
    <h1>NRV</h1>
    <ul>
         <li><a href="?action=default">Accueil</a></li>
         <li>-----------</li>
         <li><a href="?action=register">s'enregistrer</a></li>
         <li><a href="?action=signin">se connecter</a></li>
         <li><a href="?action=disconnect">Se deconnecter</a></li>
    </ul>
    $html
</body>
</html>
HEAD;
    }
}
