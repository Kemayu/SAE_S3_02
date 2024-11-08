<?php

namespace iutnc\nrv\objets;

use iutnc\nrv\exception as exception;
class Spectacle{
    protected int $id;
    protected string $titre;
    protected string $description;
    protected string $image;
    protected string $extrait;
    protected string $dateSpectacle;
    protected string $horraireSpectacle;
    protected int $duree;
    protected string $styleMusique;
    protected float $tarifs;

    public function __construct(int $id,String $t,String $d,String $i,String $e,String $date,String $h,int $duree,String $s,float $tarifs){
        $this->id = $id;
        $this -> titre = $t;
        $this -> description = $d;
        $this -> image = $i;
        $this -> extrait = $e;
        $this -> dateSpectacle = $date;
        $this -> horraireSpectacle = $h;
        $this -> duree = $duree;
        $this -> styleMusique = $s;
        $this -> tarifs = $tarifs;
    }

    public function __get($property): mixed
    {
        return property_exists($this, $property) ? $this->$property : throw new exception\InvalidPropertyNameException($property);
    }
}