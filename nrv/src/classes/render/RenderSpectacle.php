<?php
namespace iutnc\nrv\render;
use iutnc\nrv\objets as objets;
class RenderSpectacle implements renderer{
    protected objets\Spectacle $spec;
    public function __construct(objets\Spectacle $spec)
    {
        $this->spec= $spec;
    }

    public function render(): string
    {
        return "
        <div class = 'items'>
            <h3 class='mon-titre' aria-describedby='description-titre'>{$this->spec->titre} - {$this->spec->dateSpectacle}</h3>
            <p class='description-titre'>{$this ->spec->description} </p>
            <a href = 'https://apprendre-html.3wa.fr/html/comprendre-html/base-langage-html-1/rendre-image-cliquable-html'><img class='img' src='{$this->spec->image}' alt='Affiche' width='300' height='400'></a>
        </div>
        ";
    }
}