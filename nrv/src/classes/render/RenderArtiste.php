<?php
namespace iutnc\nrv\render;
use iutnc\nrv\objets as objets;
class RenderArtiste implements renderer{
    protected objets\Artiste $art;
    public function __construct(objets\Artiste $art)
    {
        $this->art= $art;
    }

    public function render($type): string
    {
        return "
        <div>
            <h2>{$this->art->nom}</h2>
        </div>
        ";
    }
}
