<?php
namespace iutnc\nrv\render;
use iutnc\nrv\objets as objets;
class RenderArtiste implements renderer{
    protected objets\Artiste $art;
    public function __construct(objets\Artiste $art)
    {
        $this->art= $art;
    }

    public function render(): string
    {
        return "
        <div>
<<<<<<< HEAD
            <h2>{$this->art->nom}</h2>
>>>>>>> 41fb9f9fb6a4de939ef0c305a3a1a97ce5d80495
        </div>
        ";
    }
}
