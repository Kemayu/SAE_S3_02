<?php
namespace iutnc\nrv\render;
use iutnc\nrv\objets as objets;
class RenderSoiree implements renderer{
    protected objets\Soiree $soir;
    public function __construct(objets\Soiree $soir)
    {
        $this->soir= $soir;
    }

    public function render(int $type): string
    {
        return "
        <div class = soiree>
            <h2>{$this->soir->__get('nom')} - {$this->soir->__get('date')}</h2>
            <p id='thematique-soiree'>{$this ->soir->__get('thematique')} </p>
            <p>{$this ->soir->__get('heure_debut')} </p>
        </div>
        ";
    }
}
