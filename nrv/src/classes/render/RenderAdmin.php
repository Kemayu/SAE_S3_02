<?php
namespace iutnc\nrv\render;
use iutnc\nrv\objets as objets;
class RenderAdmin implements renderer{
    protected objets\Utilisateur $util;
    public function __construct(objets\Utilisateur $util)
    {
        $this->util= $util;
    }

    public function render($type): string
    {
        return "
        //J'ai enlevé la partie html pour admin comme c'est les informations persos donc si il faut la rajouter ditent le moi 
        ";
    }
}
