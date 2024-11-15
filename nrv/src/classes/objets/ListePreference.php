<?php

namespace iutnc\nrv\objets;

use iutnc\nrv\exception as exception;
use iutnc\nrv\render as render;

//Classe gerant les listes de preferances
class ListePreference
{
    //Chaque Liste a comme attribut : Un nombre de spectacle et un array avec tous les spectacles notees. 
    protected int $nombreSpectacle = 0;
    protected array $spec = [];

    //initialisation des attributs
    public function __construct(array $spec = [])
    {
        $this->nombreSpectacle = count($spec);
        $this->spec = $spec;
    }

    //Getter des attributs
    public function __get($property): mixed
    {
        if(property_exists($this, $property)) {
            return $this->$property;
        } else {
            throw new exception\InvalidPropertyNameException($property);
        }
    }

    //Methode pour ajouter un spectacle dans la liste de preference
    /*
    public function ajouterSpectacle(Spectacle $spec): void
    {
        array_push($this->spec, $spec);
        $this->nombreSpectacle++;
    }
        */

    //Methode pour supprimer un spectacle de la liste de preference
    /* 
    public function supprimerSpectacle(int $index): void
    {
        unset($this->spec[$index]);
    }

    public function afficherListe(string $html) : string
    {
        $repo = \iutnc\nrv\repository\NrvRepository::getInstance();
        foreach ($this->spec as $id) {
            $html.=$id;
            $spectacle = $repo->getSpectacleById($id);
            $renderer = new render\RenderSpectacle(new Spectacle((int)$spectacle["ID_SPECTACLE"],$spectacle["TITRE_SPECTACLE"],$spectacle["DESCRIPTION_SPECTACLE"],$spectacle["IMAGE_SPECTACLE"],$spectacle["EXTRAIT_SPECTACLE"],$spectacle["DATE_SPECTACLE"],$spectacle["HORAIRE_SPECTACLE"],$spectacle["DUREE_SPECTACLE"],$spectacle["STYLE_MUSIQUE"],$spectacle["TARIF_SPECTACLE"]));
            $html.= $renderer->render(2);
            $html.="</br></br></div>";
        }
        return $html;
    }
        */

}