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


}