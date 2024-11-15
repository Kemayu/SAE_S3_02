<?php
namespace iutnc\nrv\auth;
use iutnc\nrv\exception as exception;

//Classe permettant le connexion et l'enregistrement de compte. 
class AuthnProvider
{
    //Fonction permettant de se connecter. Elle prend en parametre le mail et le mot de passe de l'utilisateur
    //et renvoie true si la connection a ete effectue
    public static function signin(string $email, string $password): bool {
        $repo = \iutnc\nrv\repository\NrvRepository::getInstance();
        $result = $repo -> verifIdRegister($email);
        if($result[0] == false){
            if(password_verify($password,$result[1])){
                $user = new User($repo->getIdUser($email),$email,$repo->getTelUser($email),$repo->getRoleUser($email));
                $_SESSION['user'] = serialize($user);
                return true;
            }else{
                throw new exception\AuthnException("echec d'authentification");
            }
        }else{
            throw new exception\AuthnException("pas réussi à se connecter");
        }
    }
    //Fonction permettant d'enregistrer un compte. Elle prend en parametre le mail et le mot de passe de l'utilisateur
    //et renvoie true si l'enregistrement a ete effectue
    public static function register(string $name, string $tel, string $email,string $password): bool{
        if (!$name === filter_var($name,FILTER_SANITIZE_STRING)) {
            throw new exception\AuthnException("Nom dangereux");
        };
        if (!$tel === filter_var($tel,FILTER_SANITIZE_STRING)) {
            throw new exception\AuthnException("numero de telephone dangereux");
        };
        if($email=== filter_var($email, FILTER_SANITIZE_EMAIL)){
            if (strpos($email, "@") !== false and strpos($email, ".") !== false ) {
                $repo = \iutnc\nrv\repository\NrvRepository::getInstance();
                if ($repo -> verifIdRegister($email)[0]){
                    $repo->register($name,$tel,$email,password_hash($password, PASSWORD_BCRYPT));
                    return true;
                }else{
                    throw new exception\AuthnException("déjà présent");
                }
            }else{
                throw new exception\AuthnException("email non valide");
           }
        }else{
            throw new exception\AuthnException("email dangereux");
        }
        }

        //fonction qui rend le mail de l'utilisateur si il est connecte
    public static function getSignInUser(): string{
        if (isset($_SESSION['user'])){
            return unserialize($_SESSION['user'])->email;
        }
        throw new exception\AuthnException("pas authentifié");
    }

    //fonction qui donne le droit de l'utilisateur si il est connecte
    public static function getUserDroit(): string{
        if (isset($_SESSION['user'])){
            return unserialize($_SESSION['user'])->role;
        }
        throw new exception\AuthnException("pas authentifié");
    }

 }


