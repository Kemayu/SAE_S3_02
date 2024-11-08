<?php
namespace iutnc\nrv\objets ;
use iutnc\nrv\exception as exception;
class Soiree{
    protected String $nom;
    protected String $date;
    protected String $thematique;
    protected String $heure_debut;

    public function __construct(String $n,String $d,String $t,String $h_d,){
        $this -> nom = $n;
        $this -> date = $d;
        $this -> thematique = $t;
        $this -> heure_debut = $h_d;
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
