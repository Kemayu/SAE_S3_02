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

    public function getAllIdNomUserNotAdminAndOrganisator():array{
        $stmt = $this ->pdo->prepare("select ID_UTILISATEUR, NOM_UTILISATEUR from utilisateur where DROIT_UTILISATEUR  = 1 ");
        $stmt->execute();
        $infos = $stmt->fetchAll();
        return $infos;
    }
    public function getAllIdNomUserOrganisator():array{
        $stmt = $this ->pdo->prepare("select ID_UTILISATEUR, NOM_UTILISATEUR from utilisateur where DROIT_UTILISATEUR  = 15 ");
        $stmt->execute();
        $infos = $stmt->fetchAll();
        return $infos;
    }

    public function findProgramSorted(String $val): array {
        $colonnes_autorisees = ['DATE_SPECTACLE', 'NOM_LIEU', 'STYLE_MUSIQUE'];

        // Vérifie que $val est dans les colonnes autorisées, sinon on utilise une colonne par défaut
        if (!in_array($val, $colonnes_autorisees, true)) {
            $val = 'date_spectacle';  // Par défaut, tri par nom_spectacle
        }
        $stmt = $this ->pdo->prepare("select distinct Spectacle.* from spectacle inner join soiree_spectacle on spectacle.id_spectacle=soiree_spectacle.id_spectacle
        inner join soiree on soiree_spectacle.id_soiree=soiree.id_soiree
        inner join lieu on soiree.id_lieu=lieu.id_lieu
        ORDER BY $val ASC");
        $stmt->execute();
        $pgrm = $stmt->fetchAll();
        return $pgrm;
    }

    public function findProgramPar(String $val, String $cond): array {
        $colonnes_autorisees = ['DATE_SPECTACLE', 'NOM_LIEU', 'STYLE_MUSIQUE'];

        // Vérifie que $val est dans les colonnes autorisées, sinon on utilise une colonne par défaut
        if (!in_array($val, $colonnes_autorisees, true)) {
            $val = 'date_spectacle';  // Par défaut, tri par nom_spectacle
        }
        $stmt = $this ->pdo->prepare("select distinct Spectacle.* from spectacle inner join soiree_spectacle on spectacle.id_spectacle=soiree_spectacle.id_spectacle
        inner join soiree on soiree_spectacle.id_soiree=soiree.id_soiree
        inner join lieu on soiree.id_lieu=lieu.id_lieu
        WHERE $val = ?");
        $stmt->bindParam(1,$cond);
        $stmt->execute();
        $pgrm = $stmt->fetchAll();
        return $pgrm;
    }

    public function recupAllLieux(){
        $stmt = $this ->pdo->prepare("select id_lieu,nom_lieu from Lieu");
        $stmt->execute();
        $lieux = $stmt->fetchAll();
        return $lieux;
    }

    public function recupAllStyles(){
        $stmt = $this ->pdo->prepare("select style_musique from spectacle");
        $stmt->execute();
        $lieux = $stmt->fetchAll();
        return $lieux;
    }

    public function createSoiree(String $name, String $thematique, String $date, String $horaire, int $idlieu):void{
        $sql ="insert into Soiree(NOM_SOIREE,DATE_SOIREE,THEMATIQUE,HORAIRE_DEBUT,ID_LIEU) values(:nom,:thematique,:date,:horaire, :idlieu)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nom',$name);
        $stmt->bindParam(':date',$date);
        $stmt->bindParam(':thematique',$thematique);
        $stmt->bindParam(':horaire',$horaire);
        $stmt->bindParam(':idlieu',$idlieu);
        $stmt->execute();
        }

    public function deleteSoiree(int $id):void{
        $sql ="DELETE FROM SOIREE WHERE id_soiree = :ID_SOIREE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ID_SOIREE',$id);
        $stmt->execute();

    }

    public function getSoireeById(int $idSoiree) : array{
        $stmt = $this->pdo->prepare("select * from soiree where ID_SOIREE = :idSoiree");
        $stmt->bindParam(':idSoiree',$idSoiree);
        $stmt->execute();
        $soiree = $stmt->fetch();
        return $soiree;
    }

    public function getALlIdNameSoiree():array{
        $sql = "select ID_SOIREE,NOM_SOIREE from SOIREE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $infos = $stmt->fetchAll();
        return $infos;
    }

    public function getIdLieu() : array{
        $sql = "select ID_LIEU,NOM_LIEU from LIEU";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $infos = $stmt->fetchAll();
        return $infos;
    }

    public function createSpectacle(String $date, String $h, int $duree, float $tarifs,String $e, String $t,String $d,String $i,String $s):void{
        $sql ="insert into spectacle(DATE_SPECTACLE , HORAIRE_SPECTACLE, DUREE_SPECTACLE , TARIF_SPECTACLE , EXTRAIT_SPECTACLE , TITRE_SPECTACLE , DESCRIPTION_SPECTACLE, IMAGE_SPECTACLE ,STYLE_MUSIQUE) values(:date,:horaire,:duree,:tarifs,:extrait,:titre,:description,:image,:style)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':date',$date);
        $stmt->bindParam(':horaire',$h);
        $stmt->bindParam(':duree',$duree);
        $stmt->bindParam(':tarifs',$tarifs);
        $stmt->bindParam(':extrait',$e);
        $stmt->bindParam(':titre',$t);
        $stmt->bindParam(':description',$d);
        $stmt->bindParam(':image',$i);
        $stmt->bindParam(':style',$s);

        $stmt->execute();

    }

    public function getSpectacleById(int $idSpec) : array{
        $stmt = $this->pdo->prepare("select * from spectacle where id_spectacle = :idS");
        $stmt->bindParam(':idS',$idSpec);
        $stmt->execute();
        $spectacle = $stmt->fetch();
        return $spectacle;
    }


    public function getLastIdSpectacle():int{
        $sql = "select MAX(ID_SPECTACLE) from SPECTACLE ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $infos = $stmt->fetchColumn();
        return $infos;
    }

    public function getALlIdTitreDescriptionSpectacle():array{
        $sql = "select ID_SPECTACLE,TITRE_SPECTACLE, DESCRIPTION_SPECTACLE from Spectacle";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $infos = $stmt->fetchAll();
        return $infos;
    }



    public function getNbSpectaclePasAnnule() : int{
        $stmt = $this ->pdo->prepare("select count(*) from Spectacle where DESCRIPTION_SPECTACLE != 'Annulé'");
        $stmt->execute();
        $nb = $stmt->fetchColumn();
        return $nb;
    }

    public function createLinkSoireeSpectacle(int $idspectacle, int $idsoiree):void{
        $sql ="insert into SOIREE_SPECTACLE(ID_SPECTACLE , ID_SOIREE) values(:ID_SPECTACLE,:ID_SOIREE)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':ID_SPECTACLE',$idspectacle);
        $stmt->bindParam(':ID_SOIREE',$idsoiree);

        $stmt->execute();

    }

    public function deleteSoireeSpectacle(int $id_spectacle, int $id_soiree):void{
        $sql ="DELETE FROM SOIREE_SPECTACLE WHERE id_spectacle = :ID_SPECTACLE AND id_soiree = :ID_SOIREE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ID_SOIREE',$id_soiree);
        $stmt->bindParam(':ID_SPECTACLE',$id_spectacle);
        $stmt->execute();

    }


    public function getIDSpectacleFromSpectacleSoiree(int $id_soiree):int{
        $sql = "select ID_SPECTACLE from SOIREE_SPECTACLE where id_soiree = :ID_SOIREE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ID_SOIREE',$id_soiree);
        $stmt->execute();
        $infos = $stmt->fetchColumn();
        return $infos;
    }
    public function setStatusSpectacle(int $id_spectacle, string $text):void{
        $sql = "UPDATE SPECTACLE SET DESCRIPTION_SPECTACLE = :text where id_spectacle = :ID_SPECTACLE ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ID_SPECTACLE',$id_spectacle);
        $stmt->bindParam(':text',$text);
        $stmt->execute();
    }

    public function setUserRole($idUser, $role):void{
        $sql ="
            UPDATE UTILISATEUR SET
               DROIT_UTILISATEUR = :role
            where ID_UTILISATEUR = :id_user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_user',$idUser);
        $stmt->bindParam(':role',$role);
        $stmt->execute();
    }

    public function updateSoiree(int $id_soiree, String $name, String $date, String $thematique , String $horaire, int $idlieu):void{
        $sql ="
            UPDATE SOIREE SET
               NOM_SOIREE = :nom,
               DATE_SOIREE = :date ,
               THEMATIQUE = :thematique ,
               HORAIRE_DEBUT = :horaire ,
               ID_LIEU = :idlieu 
            where ID_SOIREE = :id_soiree";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_soiree',$id_soiree);
        $stmt->bindParam(':nom',$name);
        $stmt->bindParam(':date',$date);
        $stmt->bindParam(':thematique',$thematique);
        $stmt->bindParam(':horaire',$horaire);
        $stmt->bindParam(':idlieu',$idlieu);
        $stmt->execute();
    }

    public function updateSpectacle(int $id, String $date, String $h, int $duree, int $tarif,String $e, String $t,String $d,String $i,String $s) : void
    {
        $sql = "UPDATE Spectacle 
            SET DATE_SPECTACLE = :date,
                HORAIRE_SPECTACLE = :horaire,
                DUREE_SPECTACLE = :duree,
                TARIF_SPECTACLE = :tarif,
                EXTRAIT_SPECTACLE = :extrait,
                TITRE_SPECTACLE = :titre,
                DESCRIPTION_SPECTACLE = :description,
                IMAGE_SPECTACLE = :image,
                STYLE_MUSIQUE = :style
            WHERE ID_SPECTACLE = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':date',$date);
        $stmt->bindParam(':horaire',$h);
        $stmt->bindParam(':duree',$duree);
        $stmt->bindParam(':tarif',$tarif);
        $stmt->bindParam(':extrait',$e);
        $stmt->bindParam(':titre',$t);
        $stmt->bindParam(':description',$d);
        $stmt->bindParam(':image',$i);
        $stmt->bindParam(':style',$s);

        $stmt->execute();
    }

    public function VerifyAdmin(int $id) : void
    {
        $sql = "select Droit_Utilisateur from utilisateur where id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':date',$date);
        $stmt->execute();
        //Pour la prochaine fois je dois surement faire en sorte que les utilisateur n'ont pas accès au modif dcp en vérifiant dans les classe action grace a cette fonction
    }




    public function getArtistesSpectacle($id){
        $stmt = $this ->pdo->prepare("select nom_artiste from Artiste inner join artiste_spectacle on artiste.id_artiste = artiste_spectacle.id_artiste
        inner join spectacle on artiste_spectacle.id_spectacle = spectacle.id_spectacle where spectacle.id_spectacle = ?");
        $stmt->bindParam(1,$id);
        $stmt->execute();
        $artistes = $stmt->fetchAll();
        return $artistes;
    }

    public function getSpectacleSoiree(int $idSoiree){
        $sql = "select spectacle.id_spectacle from soiree_spectacle inner join spectacle on soiree_spectacle.id_spectacle = spectacle.id_spectacle
        where id_soiree = ? order by horaire_spectacle";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(1,$idSoiree);
        $stmt->execute();
        $infos = $stmt->fetchAll();
        return $infos;
    }
    public function getSoireeSpectacle(int $idSpectacle){
        $sql = "select id_soiree from soiree_spectacle where ID_SPECTACLE = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(1,$idSpectacle);
        $stmt->execute();
        $infos = $stmt->fetchColumn();
        return $infos;
    }

    public function tryPreferenceExist(int $id_User, int $id_Spec): array
    {
        $sql ="SELECT * FROM UTILISATEUR_SPECTACLE WHERE ID_UTILISATEUR=:idUser AND ID_SPECTACLE=:idSpec";
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(':idUser',$id_User);
        $stmt->bindParam(':idSpec',$id_Spec);
        
        $stmt->execute();
        $spec = $stmt->fetchAll();
        return $spec;
    }

    public function addPreference(int $id_User,int $id_Spec): void
    {
        $sql ="insert into UTILISATEUR_SPECTACLE(ID_UTILISATEUR , ID_SPECTACLE) values(:idUser,:idSpec)";
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(':idUser',$id_User);
        $stmt->bindParam(':idSpec',$id_Spec);
        
        $stmt->execute();
    
    }

    public function getPreference(int $id_User):array{
        $sql ="select ID_SPECTACLE from UTILISATEUR_SPECTACLE where ID_UTILISATEUR=:idUser";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':idUser', $id_User);
        $stmt->execute();
        $spec = $stmt->fetchAll();
        return $spec;
    }

    public function RemovePreference(int $id_User,int $id_Spec): void
    {
        $sql ="DELETE FROM UTILISATEUR_SPECTACLE WHERE ID_UTILISATEUR=:idUser AND ID_SPECTACLE=:idSpec";
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(':idUser',$id_User);
        $stmt->bindParam(':idSpec',$id_Spec);
        
        $stmt->execute();
    
    }

}