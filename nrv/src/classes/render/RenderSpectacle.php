<?php
namespace iutnc\nrv\render;
use iutnc\nrv\objets as objets;
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
        return "
        <div class = 'items'>
            <h3 class='mon-titre' aria-describedby='description-titre'>{$this->spec->titre} - {$this->spec->dateSpectacle}</h3>
            <p class='description-titre'>{$this ->spec->description} </p>
            <a href = 'https://apprendre-html.3wa.fr/html/comprendre-html/base-langage-html-1/rendre-image-cliquable-html'><img class='img' src='{$this->spec->image}' alt='Affiche' width='300' height='400'></a>
        </div>
        ";
    }

    public function renderLong(): string
    {
        return "
        <div>
            <h3 id='mon-titre' aria-describedby='description-titre'>{$this->spec->titre} </h3>
            <P id='Artistes'> </p>
            <p id='description-titre'>{$this ->spec->description} </p>
            <p id='Style'>{$this->spec->styleMusique} </p>
            <p id='Duree'> {$this->spec->duree}</p>
            <img src='{$this->spec->image}' alt='Affiche' width='300' height='200'>
            <p id='Extrait'> {$this->spec->extrait} </p>
        </div>
        ";
    }
}