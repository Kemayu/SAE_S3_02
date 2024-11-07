<?php

namespace iutnc\nrv\objets;

use iutnc\nrv\exception as exception;
class Spectacle{
    protected String $titre;
    protected String $description;
    protected String $image;
    protected String $extrait;
    protected String $dateSpectacle;
    protected String $horraireSpectacle;
    protected int $duree;
    protected String $styleMusique;
    protected Int $tarifs;

    public function __construct(String $t,String $d,String $i,String $e,String $date,String $h,int $duree,String $s,int $tarifs){
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