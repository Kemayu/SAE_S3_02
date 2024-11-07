<?php
namespace iutnc\nrv\objet ;
use iutnc\nrv\exception as exception;
class Soirée{
    protected String $nom;
    protected String $email;
    protected String $telephone;
    protected int $droit;
    protected String $password;

    public function __construct(String $n,String $e,String $t,int d,String p){
        $this -> nom = $n;
        $this -> email = $e;
        $this -> thematique = $t;
        $this -> droit = $d;
        $this -> password = $p;
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
