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
            <P id='Artistes'> IL Y A DES PROBLEMES DANS L AFFICHAGE DES ARTISTES</p>
            <p id='description-titre'>{$this ->spec->description} </p>
            <p id='Style'>Style: {$this->spec->styleMusique} </p>
            <p id='Duree'>Duree: {$this->spec->duree} min.</p>
            <img src='{$this->spec->image}' alt='Affiche' width='300' height='200'>

            <iframe width='560' height='315' src='{$this->spec->extrait}' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' referrerpolicy='strict-origin-when-cross-origin' allowfullscreen></iframe>

            
        </div>
        ";
    }
}