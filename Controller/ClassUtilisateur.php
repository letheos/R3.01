<?php


class Utilisateur implements Serializable {
    private $login;
    private $password;
    private $firstName;
    private $lastName;
    private $role;
    private $email;
    private $lesFormations;

    /**
     * @param $login
     * @param $password
     * @param $firstName
     * @param $lastName
     * @param $role
     * @param $email
     * @param $lesFormations
     */
    public function __construct($login, $password, $firstName, $lastName, $role, $email,$lesFormations)
    {
        $this->login = $login;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->role = $role;
        $this->email = $email;
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
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $idRole
     */
    public function setRole($role)
    {
        $this->role = $role;
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
    public function getLesFormations()
    {
        return $this->lesFormations;
    }

    /**
     * @param mixed $lesFormations
     */
    public function setLesFormations($lesFormations): void
    {
        $this->lesFormations = $lesFormations;
    }



    public function createUser($password,$lastName,$firstName,$email,$login,$idRole,$lesFormations){
        try {
            require '../Model/ModelInsertUpdateDelete.php';
            $conn = require '../Model/Database.php';
            adduserbdd($conn,$password,$lastName,$firstName,$email,$login,$idRole);
            addrolesbdd($conn,$login,$lesFormations);
        }catch (Exception $e ){
            header('Location: ControllerMailConfig.php');
        }
    }


    public function serialize()
    {
        return serialize([$this->login, $this->password, $this->firstName, $this->lastName, $this->role, $this->email,$this->lesFormations]);
    }

    public function unserialize($data)
    {
        list($this->login,$this->password, $this->firstName, $this->lastName, $this->role, $this->email,$this->lesFormations) = unserialize($data);
    }
}