<?php
namespace iutnc\nrv\repository;
use iutnc\nrv\auth as auth;

//Classe gerant les interactions avec la base de donnees
class NrvRepository{
    //Attributs
    private \PDO $pdo;
    private static ?NrvRepository $instance = null; private static array $config = [ ];

    //initialisation des attributs
    private function __construct(array $conf) {
        $dsn = self::$config['drive'].":host=" .self::$config['host'] . ";dbname=".self::$config['database'];
        $this->pdo = new \PDO($dsn, self::$config['user'], self::$config['pass'], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }

    //Getter pour l'instance
    public static function getInstance(): NrvRepository{
        if (is_null(self::$instance)) {
            self::$instance = new NrvRepository(self::$config);
        }
        return self::$instance;
    }

    //Setter de config
    public static function setConfig(string $file): void {
        $conf = parse_ini_file($file);
        if ($conf===false) {
           throw new \Exception("Error reading configuration file");
        }
        
        self::$config = [ 'database'=> $conf["database"],'user'=> $conf['username'], 'pass'=> $conf['password'],'host' =>$conf['host'],"drive"=>$conf['drive']];
    }

     //Fonction qui donne le mot de passe si l'email existe dans la base de donnees
     public function verifIdRegister(String $email) : array{
        $sql ="select count(*) from utilisateur where EMAIL_UTILISATEUR = :email ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        $result = $stmt->fetchColumn(); 
        if ($result == 0){
            return [true,null];
        }
        $stmt = $this->pdo->prepare("select PASSWORD_UTILISATEUR from utilisateur where EMAIL_UTILISATEUR = :email");
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        $passwd = $stmt->fetchColumn();
        return[false,$passwd];
    }

    //Fonction pour s'enregistrer
    public function register(String $name, String $tel, String $email,string $password):void{
        $sql ="insert into utilisateur(NOM_UTILISATEUR,EMAIL_UTILISATEUR,TELEPHONE_UTILISATEUR,PASSWORD_UTILISATEUR,DROIT_UTILISATEUR) values(:nom,:email,:tel,:pwd,:role)";
        $role = 1;
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nom',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':tel',$tel);
        $stmt->bindParam(':pwd',$password);
        $stmt->bindParam(':role',$role);
        $stmt->execute();
    }

}