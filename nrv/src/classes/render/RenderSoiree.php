<?php
namespace iutnc\nrv\render;
use iutnc\nrv\objets as objets;
class RenderSoiree implements renderer{
    protected objets\Soiree $soir;
    public function __construct(objets\Soiree $soir)
    {
        $this->soir= $soir;
    }

    public function render(): string
    {
        return "
        <div>
<<<<<<< HEAD
            <h3 id='nom-soiree'>{$this->soir->nom}</h3>
            <p id='thematique-soiree'>{$this ->soir->thematique} </p>
            <h2>{$this->soir->nom} - {$this->soir->date}</h2>
            <p>{$this ->soir->heure_debut} </p>
>>>>>>> 41fb9f9fb6a4de939ef0c305a3a1a97ce5d80495
        </div>
        ";
    }
}
