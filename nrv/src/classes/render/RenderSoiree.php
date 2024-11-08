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
            <h3 id='nom-soiree'>{$this->soir->nom}</h3>
            <p id='thematique-soiree'>{$this ->soir->thematique} </p>
            <h2>{$this->soir->nom} - {$this->soir->date}</h2>
            <p>{$this ->soir->heure_debut} </p>
        </div>
        ";
    }
}
