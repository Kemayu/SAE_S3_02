<?php
namespace iutnc\nrv\objets ;
use iutnc\nrv\exception as exception;
class Artiste{
    protected String $nom;

    public function __construct(String $n){
        $this -> nom = $n;
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
