<?php


class ConnexionSGBD
{

    private static $instance;
    private String $database;
    private String $user;
    private String $password;


    private function __construct(){
        $this->database = "BDDInterne";
        $this->user = "root";
        $this->password = "root";
    }


    public static function getInstance(): ConnexionSGBD
    {
        return self::$instance;
    }

    public static function creerInstance():ConnexionSGBD{
        if (self::$instance == null){
            self::$instance = new ConnexionSGBD();
        } else {
            print_r("Instance déjà existante !");
        }

        return self::$instance;
    }

    public  function connect():PDO{
        return new PDO("mysql:host=localhost;dbname=".$this->database, $this->user, $this->password);
    }

}