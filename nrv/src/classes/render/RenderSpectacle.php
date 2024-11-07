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
<<<<<<< HEAD
            <h3 id='mon-titre' aria-describedby='description-titre'>{$this->spec->titre} - {$this->spec->dateSpectacle}</h3>
            <p id='description-titre'>{$this ->spec->description} </p>
=======
            <h2>{$this->spec->titre} - {$this->spec->dateSpectacle}</h2>
            <p>{$this ->spec->description} </p>
            <img src='{$this->spec->image}' alt='Affiche' width='300' height='200'>
>>>>>>> 41fb9f9fb6a4de939ef0c305a3a1a97ce5d80495
        </div>
        ";
    }
}