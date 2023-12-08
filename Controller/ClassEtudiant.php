<?php

class Etudiant {
    private $idCandidat;
    private $INE;
    private $nom;
    private $prenom;
    private $nameParcours;
    private $yearsOfFormation;
    private $isInActiveSearch;
    private $isPermisB;
    private $typeCompanySearch;
    private $cheminPDF;
    private $autresInformations;
    private $phoneNumber;
    private $candidateMail;

    /**
     * @param $idCandidat
     * @param $nom
     * @param $prenom
     * @param $nameParcours
     * @param $yearsOfFormation
     * @param $isInActiveSearch
     * @param $isPermisB
     * @param $typeCompanySearch
     * @param $autresInformations
     * @param $phoneNumber
     * @param $candidateMail
     */
    public function __construct($idCandidat, $nom, $prenom, $nameParcours, $yearsOfFormation, $isInActiveSearch, $isPermisB, $typeCompanySearch, $autresInformations, $phoneNumber, $candidateMail)
    {
        $this->idCandidat = $idCandidat;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->nameParcours = $nameParcours;
        $this->yearsOfFormation = $yearsOfFormation;
        $this->isInActiveSearch = $isInActiveSearch;
        $this->isPermisB = $isPermisB;
        $this->typeCompanySearch = $typeCompanySearch;
        $this->autresInformations = $autresInformations;
        $this->phoneNumber = $phoneNumber;
        $this->candidateMail = $candidateMail;
    }

    /**
     * @return mixed
     */
    public function getIdCandidat()
    {
        return $this->idCandidat;
    }

    /**
     * @param mixed $idCandidat
     */
    public function setIdCandidat($idCandidat)
    {
        $this->idCandidat = $idCandidat;
    }

    /**
     * @return mixed
     */
    public function getINE()
    {
        return $this->INE;
    }

    /**
     * @param mixed $INE
     */
    public function setINE($INE)
    {
        $this->INE = $INE;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getNameParcours()
    {
        return $this->nameParcours;
    }

    /**
     * @param mixed $nameParcours
     */
    public function setNameParcours($nameParcours)
    {
        $this->nameParcours = $nameParcours;
    }

    /**
     * @return mixed
     */
    public function getYearsOfFormation()
    {
        return $this->yearsOfFormation;
    }

    /**
     * @param mixed $yearsOfFormation
     */
    public function setYearsOfFormation($yearsOfFormation)
    {
        $this->yearsOfFormation = $yearsOfFormation;
    }

    /**
     * @return mixed
     */
    public function getIsInActiveSearch()
    {
        return $this->isInActiveSearch;
    }

    /**
     * @param mixed $isInActiveSearch
     */
    public function setIsInActiveSearch($isInActiveSearch)
    {
        $this->isInActiveSearch = $isInActiveSearch;
    }

    /**
     * @return mixed
     */
    public function getIsPermisB()
    {
        return $this->isPermisB;
    }

    /**
     * @param mixed $isPermisB
     */
    public function setIsPermisB($isPermisB)
    {
        $this->isPermisB = $isPermisB;
    }

    /**
     * @return mixed
     */
    public function getTypeCompanySearch()
    {
        return $this->typeCompanySearch;
    }

    /**
     * @param mixed $typeCompanySearch
     */
    public function setTypeCompanySearch($typeCompanySearch)
    {
        $this->typeCompanySearch = $typeCompanySearch;
    }

    /**
     * @return mixed
     */
    public function getCheminPDF()
    {
        return $this->cheminPDF;
    }

    /**
     * @param mixed $cheminPDF
     */
    public function setCheminPDF($cheminPDF)
    {
        $this->cheminPDF = $cheminPDF;
    }

    /**
     * @return mixed
     */
    public function getAutresInformations()
    {
        return $this->autresInformations;
    }

    /**
     * @param mixed $autresInformations
     */
    public function setAutresInformations($autresInformations)
    {
        $this->autresInformations = $autresInformations;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getCandidateMail()
    {
        return $this->candidateMail;
    }

    /**
     * @param mixed $candidateMail
     */
    public function setCandidateMail($candidateMail)
    {
        $this->candidateMail = $candidateMail;
    }

    public function afficherPDF() {
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($this->cheminPDF) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($this->cheminPDF));
        header('Accept-Ranges: bytes');

        readfile($this->cheminPDF);
    }
}
