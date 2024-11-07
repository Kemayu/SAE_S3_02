<?php
namespace iutnc\nrv\render;
use iutnc\nrv\objets as objets;
class RenderLieu implements renderer{
    protected objets\Lieu $lieu;
    public function __construct(objets\Lieu $lieu)
    {
        $this->lieu= $lieu;
    }

    public function render(): string
    {
        return "
        <div>
<<<<<<< HEAD
            <h3 id='nom-lieu'>{$this->lieu->nom}</h3>
            <p id='adresse-lieu'>{$this ->lieu->adresse} </p>
            <p>{$this->lieu->place_debout>}</p>
            <p>{$this->lieu->place_assises>}</p>
            <img src='{$this->lieu->image}' alt='Affiche' width='300' height='200'>
>>>>>>> 41fb9f9fb6a4de939ef0c305a3a1a97ce5d80495
        </div>
        ";
    }
}
