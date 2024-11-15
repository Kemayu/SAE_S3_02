<?php
declare(strict_types=1);

namespace iutnc\nrv\dispatch;

use iutnc\nrv\action as act;
use iutnc\nrv\auth\AuthnProvider;
use iutnc\nrv\exception\AuthnException;

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
        switch ($this->action) {
            case 'register' : 
                $action = new act\RegisterAction();
                break;
            case 'signin' : 
                $action = new act\SignInAction();
                break;
            case 'disconnect':
                $action = new act\DisconnectAction();
                break;
            case 'create-spectacle' :
                $action = new act\CreateSpectacleAction();
                break;
            case 'add-soiree':
                $action = new act\CreateSoireeAction();
                break;
            case 'modify-spectacle':
                $action = new act\ModifySpectacleAction();
                break;
            case 'display-sorted':
                $action = new act\DisplayProgSorted();
                break;
            case 'delete-soiree':
                $action = new act\DeleteSoireeAction();
                break;
            case 'display-par':
                $action = new act\DisplayProgPar();
                break;
            case 'display-spec':
                    $action = new act\DisplaySpectacle();
                    break;
            case 'cancel-spectacle':
                $action = new act\CancelSpectacleAction();
                break;
            case 'modify-soiree':
                $action = new act\ModifySoireeAction();
                break;
            case 'add-preference':
                $action = new act\AddSpectaclePreference();
                break;
            case 'display-preference':
                $action = new act\DisplayPreference();
                break;
            default :
                $action = new act\DefaultAction();
                break;
        }

        try {
            $html = $action->execute();

            if (AuthnProvider::getUserDroit() == 15) {
                $this->renderPageAdmin($html);
            }
            elseif(AuthnProvider::getUserDroit() == 50) {
                $this->renderPageAdmin($html);
        }
            elseif(AuthnProvider::getUserDroit() == 1) {
                $this->renderPageUtilisateur($html);
            }
    }catch(AuthnException $e1){
            $this->renderPageUtilisateur($html);}
    }

    //fonction permettant d'afficher la page web
    private function renderPageAdmin(string $html): void
    {
        echo <<<HEAD
<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="css/style.css" rel="stylesheet" />
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
         <li>-----------</li>
         <li><a href="?action=add-soiree">Crée la soirée</a></li>
         <li><a href="?action=create-spectacle">Creer un spectacle</a></li>
         <li>-----------</li>
        <li><a href="?action=modify-soiree">Modifier la soirée</a></li>
        <li><a href="?action=modify-spectacle">Modifier le spectacle</a></li>
        <li><a href="?action=cancel-spectacle">Annulé le spectacle</a></li>
        <li><a href="?action=delete-soiree">Supprimé la Soirée</a></li>
        <li>-----------</li>
         <li><a href="?action=display-sorted">Afficher le programme de manière triée</a></li>
         <li><a href="?action=display-par">Afficher le programme de manière par..</a></li>
         <li><a href="?action=display-preference">Afficher les preferences</a></li>
         
         
    </ul>
        $html
</body>
</html>
HEAD;
    }
    private function renderPageUtilisateur(string $html): void
    {
        echo <<<HEAD
<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="css/style.css" rel="stylesheet" />
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
         <li>-----------</li>
         <li><a href="?action=display-sorted">Afficher le programme de manière triée</a></li>
         <li><a href="?action=display-par">Afficher le programme de manière par..</a></li>
         <li>-----------</li>
         <li><a href="?action=display-preference">Afficher les preferences</a></li>
         
         
    </ul>
        $html
</body>
</html>
HEAD;
    }
}
