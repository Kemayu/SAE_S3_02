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
        <div>
            <h2>{$this->spec->titre} - {$this->spec->dateSpectacle}</h2>
            <p>{$this ->spec->description} </p>
            <img src='{$this->spec->image}' alt='Affiche' width='300' height='200'>
        </div>
        ";
    }
}