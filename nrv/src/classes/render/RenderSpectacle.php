<?php
namespace iutnc\nrv\render;
use iutnc\nrv\objet as objet;
class RenderSpectacle implements renderer{
    protected objet\Spectacle $spec;
    public function __construct(objet\Spectacle $spec)
    {
        $this->spec= $spec;
    }

    public function render(int $type): string
    {
        return "
        <div>
            <h3 id='mon-titre' aria-describedby='description-titre'>{$this->spectacle->titre} - {$this->albumTrack->dateSpectacle}</h3>
            <p id='description-titre'>{$this ->spectacle->description} </p>
        </div>
        ";
    }
}