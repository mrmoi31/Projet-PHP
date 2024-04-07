<?php
class connexionBdGen{
    public static connexionBdGen | null $_instance = null;
    private PDO $_pdo;

    //Constructeur
    private function __construct(){
        try{
            $base_url = "mysql:host=%s;dbname=%s";
            $url = sprintf($base_url, "mysql-medecin.alwaysdata.net", "medecin_projet_php");
            $this->_pdo = new PDO($url, "root", "");
        }catch (PDOException $e){
            die('Erreur: ' . $e->getMessage());

        }
    }

    //Getters
    public function getPDO(): PDO{
        return $this->_pdo;
    }

    //Singleton
    public static function getInstance (): ?PDO{
        if (is_null(self::$_instance)){
            self::$_instance = new connexionBdGen();
        }
        return self::$_instance->getPDO();
    }
}
?>

