<?php
namespace iutnc\nrv\auth;
use iutnc\nrv\exception as exception;

//Classe gerant les utilisateurs
class User{
    //Un utilisateur possede un identifiant, un email et un role. Nous n'avons pas acces a son mot de passe
    private int $id;
    private string $email;
    private string $NumTel;
    private int $role;
    
    //initialisation des attributs
    public function __construct(int $id, string $mail, string $tel, int $role)
    {
        $this->id = $id;
        $this->email = $mail;
        $this->NumTel = $tel;
        $this->role = $role;
    }

    //Getter des attributs
    public function __get($property): mixed
    {
        if(property_exists($this, $property)) {
            return $this->$property;
        } else {
            throw new exception\InvalidPropertyNameException($property);
        }
    }

}