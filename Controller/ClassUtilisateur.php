<?php
include '../Model/ModelInsertUpdateDelete.php';

class Utilisateur{
    private $login;
    private $password;
    private $firstName;
    private $lastName;
    private $idRole;
    private $nameFormation;
    private $email;
    private $conn;
    private $lesFormations;

    /**
     * @param $login
     * @param $password
     * @param $firstName
     * @param $lastName
     * @param $idRole
     * @param $nameFormation
     * @param $email
     * @param $conn
     * @param $lesFormations
     */
    public function __construct($login, $password, $firstName, $lastName, $idRole, $email, $conn,$lesFormations)
    {
        $this->login = $login;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->idRole = $idRole;
        $this->email = $email;
        $this->conn = $conn;
        $this->lesFormations = $lesFormations;
    }


    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getIdRole()
    {
        return $this->idRole;
    }

    /**
     * @param mixed $idRole
     */
    public function setIdRole($idRole)
    {
        $this->idRole = $idRole;
    }

    /**
     * @return mixed
     */
    public function getNameFormation()
    {
        return $this->nameFormation;
    }

    /**
     * @param mixed $nameFormation
     */
    public function setNameFormation($nameFormation)
    {
        $this->nameFormation = $nameFormation;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * @param mixed $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function createUser(){
        try {
            adduserbdd($this->conn,$this->password,$this->lastName,$this->firstName,$this->email,$this->login,$this->idRole);
            addrolesbdd($this->conn,$this->login,$this->lesFormations);
        }catch (Exception $e ){
            header('Location: ControllerMailConfig.php');
        }
    }



}