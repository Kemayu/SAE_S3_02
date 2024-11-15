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
            case 'remove-preference':
                $action = new act\RemovePreference();
                break;
            case 'add-organisator':
                $action = new act\AddOrganisatorAction();
                break;
            case 'remove-organisator':
                $action = new act\RemoveOrganisatorAction();
                break;
            default :
                $action = new act\DefaultAction();
                break;
        }

        try {
            $html = $action->execute();

            if (AuthnProvider::getUserDroit() == 15) {
                $this->renderPageOrganisator($html);
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
    <ul id="nav">
        <li id="navHome"><a href="?action=default">Accueil</a></li>
    
        
        <li class="categ">
            <a href="#" class="dropbtn">Gestion des soirées</a>
            <div class="categ-content">
                <a href="?action=add-soiree">Créer la soirée</a>
                <a href="?action=modify-soiree">Modifier la soirée</a>
                <a href="?action=delete-soiree">Supprimer la soirée</a>
            </div>
        </li>
        
        <li class="categ">
            <a href="#" class="dropbtn">Gestion des spectacles</a>
            <div class="categ-content">
                <a href="?action=create-spectacle">Créer un spectacle</a>
                <a href="?action=modify-spectacle">Modifier le spectacle</a>
                <a href="?action=cancel-spectacle">Annuler le spectacle</a>
                <a href="?action=display-spec">Afficher un spectacle</a>
            </div>
        </li>
        
        <li class="categ">
            <a href="#" class="dropbtn">Afficher le programme</a>
            <div class="categ-content">
                <a href="?action=display-sorted">Afficher de manière triée</a>
                <a href="?action=display-par">Afficher de manière par...</a>
                <a href="?action=display-preference">Afficher mes préférences</a>
            </div>
        </li>
        
        <li class="categ">
            <a href="#" class="dropbtn">Utilisateur</a>
            <div class="categ-content">
                <a href="?action=add-organisator"> Ajouter un organisateur</a>
                <a href="?action=remove-organisator">Retiré un organisateur</a>
                <a href="?action=register">S'enregistrer</a>
                <a href="?action=signin">Se connecter</a>
                <a href="?action=disconnect">Se déconnecter</a>
            </div>
        </li>
    </ul>
        $html
</body>
</html>
HEAD;
    }

    private function renderPageOrganisator(string $html): void
    {
        echo <<<HEAD
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="shortcut icon" href="images/logo.png" type="image/png">
    <link href="css/style.css" rel="stylesheet" />
    <meta charset="UTF-8">
    <title>NRV</title>
</head>
<body>
    <ul id="nav">
        <li id="navHome"><a href="?action=default">Accueil</a></li>
        
        <li class="categ">
            <a href="#" class="dropbtn">Gestion des soirées</a>
            <div class="categ-content">
                <a href="?action=add-soiree">Créer la soirée</a>
                <a href="?action=modify-soiree">Modifier la soirée</a>
                <a href="?action=delete-soiree">Supprimer la soirée</a>
            </div>
        </li>
        
        <li class="categ">
            <a href="#" class="dropbtn">Gestion des spectacles</a>
            <div class="categ-content">
                <a href="?action=create-spectacle">Créer un spectacle</a>
                <a href="?action=modify-spectacle">Modifier le spectacle</a>
                <a href="?action=cancel-spectacle">Annuler le spectacle</a>
                <a href="?action=display-spec">Afficher un spectacle</a>
            </div>
        </li>
        
        <li class="categ">
            <a href="#" class="dropbtn">Afficher le programme</a>
            <div class="categ-content">
                <a href="?action=display-sorted">Afficher de manière triée</a>
                <a href="?action=display-par">Afficher de manière par...</a>
                <a href="?action=display-preference">Afficher mes préférences</a>
            </div>
        </li>
        
        <li class="categ">
            <a href="#" class="dropbtn">Utilisateur</a>
            <div class="categ-content">
                <a href="?action=register">S'enregistrer</a>
                <a href="?action=signin">Se connecter</a>
                <a href="?action=disconnect">Se déconnecter</a>
            </div>
        </li>
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
    <ul>
         <ul id="nav">
        <li id="navHome"><a href="?action=default">Accueil</a></li>
        
        <li class="categ">
            <a href="#" class="dropbtn">Afficher le programme</a>
            <div class="categ-content">
                <a href="?action=display-sorted">Afficher de manière triée</a>
                <a href="?action=display-par">Afficher de manière par...</a>
                <a href="?action=display-preference">Afficher mes préférences</a>
            </div>
        </li>
        
        <li class="categ">
            <a href="#" class="dropbtn">Utilisateur</a>
            <div class="categ-content">
                <a href="?action=register">S'enregistrer</a>
                <a href="?action=signin">Se connecter</a>
                <a href="?action=disconnect">Se déconnecter</a>
            </div>
        </li>
    </ul>
         
         
    </ul>
        $html
</body>
</html>
HEAD;
    }
}
