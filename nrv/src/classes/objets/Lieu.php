<?php
namespace iutnc\nrv\objets ;
use iutnc\nrv\exception as exception;
class Lieu{
    protected String $nom;
    protected String $adresse;
    protected Int $place_debout;
    protected Int $place_assises;
    protected String $image;

    public function __construct(String $n,String $a,Int $p_d,Int $p_a,String $i){
        $this -> nom = $n;
        $this -> adresse = $a;
        $this -> place_debout = $p_d;
        $this -> place_assises = $p_a;
        $this -> image = $i;
    }

    public function __get($property): mixed
    {
        if(property_exists($this, $property)) {
            return $this->$property;
        } else {
            throw new exception\InvalidPropertyNameException($property);
        }
    }
}
