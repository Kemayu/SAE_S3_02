<?php
namespace iutnc\nrv\repository;
use iutnc\nrv\objets as objets;

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

    public function getSpectacleById(int $idSpec) :objets\Spectacle{
        $stmt = $this->pdo->prepare("select * from spectacle where id_spectacle = :idS");
        $stmt->bindParam(':idS',$idSpec);
        $stmt->execute();
        $spectacle = $stmt->fetch();
        $s = new objets\Spectacle($spectacle["TITRE_SPECTACLE"],$spectacle["DESCRIPTION_SPECTACLE"],$spectacle["IMAGE_SPECTACLE"],$spectacle["EXTRAIT_SPECTACLE"],$spectacle["DATE_SPECTACLE"],$spectacle["HORAIRE_SPECTACLE"],$spectacle["DUREE_SPECTACLE"],$spectacle["STYLE_MUSIQUE"],$spectacle["TARIF_SPECTACLE"]);
        return $s;
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
    //Getter de l'id de l'utilisateur
    public function getIdUser(String $email):int{
        $stmt = $this ->pdo->prepare("select id_utilisateur from utilisateur where email_utilisateur = ?");
        $stmt->bindParam(1,$email);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        return $id;
    }
    //Getter du role de l'utilisateur
    public function getRoleUser(String $email):int{
        $stmt = $this ->pdo->prepare("select droit_utilisateur from utilisateur where email_utilisateur = ?");
        $stmt->bindParam(1,$email);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        return $id;
    }

    //Getter du numero de telephone de l'utilisateur
    public function getTelUser(String $email):String{
        $stmt = $this ->pdo->prepare("select telephone_utilisateur from utilisateur where email_utilisateur = ?");
        $stmt->bindParam(1,$email);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        return $id;
    }
<<<<<<< HEAD

    //
    public function findProgramSorted(String $val): String {
        $stmt = $this ->pdo->prepare("select * from spectacle inner join soiree_spectacle on spectacle.idspectacle=soiree_spectacle.idspectacle
        inner join soiree on soiree_spectacle.idsoiree=soiree.idsoiree
        inner join lieu_soiree on soiree.idlieu=lieu_soiree.idlieu
        inner join lieu on lieu_soiree.idlieu=lieu.idlieu
        ORDER BY ?");
        $stmt->bindParam(1,$val);
        $stmt->execute();
        $pgrm = $stmt->fetchColumn();
        return $pgrm;
=======
    public function createsoiree(String $name, String $thematique, String $date, String $horraire):void{
        $sql ="insert into Soiree(NOM_SOIREE,DATE_SOIREE,THEMATIQUE,HORRAIRE_DEBUT) values(:nom,:thematique,:date,:horraire)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nom',$name);
        $stmt->bindParam(':thematique',$thematique);
        $stmt->bindParam(':date',$date);
        $stmt->bindParam(':horraire',$horraire);
        $stmt->execute();
    }

    public function createSpectacle(String $date, String $h, int $duree, int $tarifs,String $e, String $t,String $d,String $i,String $s):void{
        $sql ="insert into spectacle(DATE_SPECTACLE , HORAIRE_SPECTACLE, DUREE_SPECTACLE , TARIF_SPECTACLE , EXTRAIT_SPECTACLE , TITRE_SPECTACLE , DESCRIPTION_SPECTACLE, IMAGE_SPECTACLE ,STYLE_MUSIQUE) values(:date,:horraire,:duree,:tarifs,:extrait,:titre,:description,:image,:style)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':date',$date);
        $stmt->bindParam(':horraire',$h);
        $stmt->bindParam(':duree',$duree);
        $stmt->bindParam(':tarifs',$tarifs);
        $stmt->bindParam(':extrait',$e);
        $stmt->bindParam(':titre',$t);
        $stmt->bindParam(':description',$d);
        $stmt->bindParam(':image',$i);
        $stmt->bindParam(':style',$s);

        $stmt->execute();
>>>>>>> 156170a6e34072fea2721c4bc5cf14df063dc549
    }
}