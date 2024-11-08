<?php
namespace iutnc\nrv\render;
use iutnc\nrv\objets as objets;
class RenderUtilisateur implements renderer{
    protected objets\Utilisateur $util;
    public function __construct(objets\Utilisateur $util)
    {
        $this->util= $util;
    }

    public function render(): string
    {
        return "
        //J'ai enlevé la partie html pour utilisateur comme c'est les informations persos donc si il faut la rajouter ditent le moi 
        ";
    }
}
