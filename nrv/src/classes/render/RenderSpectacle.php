<?php
namespace iutnc\nrv\render;
use iutnc\nrv\objets as objets;
use iutnc\nrv\repository as repository;
class RenderSpectacle implements renderer{
    protected objets\Spectacle $spec;
    public function __construct(objets\Spectacle $spec)
    {
        $this->spec= $spec;
    }

    //permet de choisir la methode d'affichage
    public function render(int $type): string
    {
        switch ($type) {
            case self::COMPACT:
                print(self::COMPACT);
                return $this->renderCompact() . "\n";
            case self::LONG:
                print(self::LONG);
                return $this->renderLong() . "\n";
            default:
                return "Type de rendu inconnu";
        }
    }

    public function renderCompact(): string
    {
        $id = (String)$this->spec->id;
        $url= "?id=". $id;
        $url.="&action=display-spec";
        return "
        <div class = 'items'>
            <h3 class='mon-titre' aria-describedby='description-titre'>{$this->spec->titre} - {$this->spec->dateSpectacle}</h3>
            <p class='description-titre'>{$this ->spec->description} </p>
            <a href = $url><img class='img' src='{$this->spec->image}' alt='Affiche' width='300' height='400'></a>
        </div>
        ";
    }

    public function renderLong(): string
    {
        $repo = repository\NrvRepository::getInstance();
        $id = (String)$this->spec->id;
        $artistes = $repo->getArtistesSpectacle((int)$id);
        $ensembleArtiste = "";
        forEach($artistes as $artiste){
            $ensembleArtiste.= $artiste["nom_artiste"] . " - ";
        }
        
        return "
        <div class = 'items'>
            <h3 id='mon-titre' aria-describedby='description-titre'>{$this->spec->titre} </h3>
            <P id='Artistes'> $ensembleArtiste</p>
            <p id='description-titre'>{$this ->spec->description} </p>
            <p id='Style'>Style: {$this->spec->styleMusique} </p>
            <p id='Duree'>Duree: {$this->spec->duree} min.</p>
            <img src='{$this->spec->image}' alt='Affiche' width='300' height='200'>
            <video src={$this->spec->extrait}>Extrait</video>
        
        </div>
        ";
    }
}