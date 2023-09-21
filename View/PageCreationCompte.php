
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../Model/PageCreationcss.css">
    <title>Document</title>
</head>
<body>
<div class = "rounded-box">


<form action="PageCreation.php" method="post">
    <label for="INE">INE</label>
    <input type="number" name="INE" value="<?php echo isset($_POST['INE']) ? $_POST['INE'] : ''; ?>">
    <br>
    <br>
    <label for="lastName ">Nom de l'étudiant</label>

    <input type="text" name="lastName " value="<?php echo isset($_POST['lastName ']) ? $_POST['lastName '] : ''; ?>">
    <br>
    <br>
    <label for="firstName">Prenom</label>
    <input type="text" name="firstName" value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : ''; ?>"><br>
    <br>
    <label for="adresse">Adresse</label>
    <input type="text" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : '';   ?>"><br>
    <br>
    <label for="mail">mail</label>
    <input type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"> <br>
    <br>
    <label for="coordonnes">coordonnes</label>
    <input type="text" name="coordonnes" value="<?php echo isset($_POST['coordonnes']) ? $_POST['coordonnes'] : ''; ?>"> <br>
    <br>
    <label for="radius">rayon</label>
    <input type="range" min="0" max="100" name="radius" value="<?php echo isset($_POST['radius']) ? $_POST['radius'] : ''; ?>"> <br>
    <br>

    <label for="typeEntrepriseRecherche">type des entreprises recherchées</label>
    <input type="text" name="typeEntreprises" value="<?php echo isset($_POST['typeEntreprises']) ? $_POST['typeEntreprises'] : '';   ?>"><br>
    <br>



    <label for="formation">formation</label>
    <select name="formation" size="1" >
        <option>mph</option>
        <option>BUT informatique</option>
    </select>
    <br>
    <br>
    <label for="permisB">permisB</label>
    <select name="permisB" size="1" >
        <option>oui</option>
        <option>non</option>
    </select>
<br>
    <br>
    <label for="cv">inserer le cv ici</label>
    <input type="file" name="cv" value="<?php echo isset($_POST['cv']) ? $_POST['cv'] : '';   ?>" accept=".pdf"><br>
    <br>>

    <button name="envoyer" class="btn btn-outline-primary" type="submit">inscription</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<?php

/*
if (isset($_POST['envoyer'])){
    $INE = $_POST['INE'];
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $address = $_POST['address'];
    $mail = $_POST['email'];
    $formation  = $_POST['menu'];
    $typeEntrepriseRecherche = $_POST['typeEntreprises'];
    $permisB = $_POST['permisB'];
    $cv = $_POST['cv'];
    $coord = $_POST['coordonnes'];
    $radius = $_POST['radius'];
*/
if (isset($_POST['envoyer'])) {
    // Récupération des valeurs du formulaire
    $INE = $_POST['INE'];
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $address = $_POST['address'];
    $mail = $_POST['email'];
    $formation = $_POST['formation'];
    $typeEntrepriseRecherche = $_POST['typeEntreprises'];
    $permisB = $_POST['permisB'];
    $cv = $_POST['cv'];
    $coord = $_POST['coordonnes'];
    $radius = $_POST['radius'];


    }

    if (preg_match('/[^A-Za-z0-9"\';]/', $lastName
    )){
        echo('<div class="alert alert-warning" role="alert">
        le nom contient un caractère spécial
      </div>');
    }

    elseif (preg_match("/[0-9]/", $lastName
    )){
        echo('<div class="alert alert-warning" role="alert">
                le nom contient un chiffre
          </div>');
    }

    elseif (preg_match('/[^A-Za-z0-9"\';]/', $firstName
    )){
        echo('<div class="alert alert-warning" role="alert">
        le prénom contient un caractère spécial
      </div>');
    }

    elseif (preg_match("/[0-9]/", $firstName
    )){
        echo('<div class="alert alert-warning" role="alert">
                le prénom contient un chiffre
          </div>');
    }


    elseif (
        $firstName == null ||$lastName == null||$mail ==null||$mail == null||$INE == null||$formation == null || $formation == null ||$coord == null){
        echo ('<div class="alert alert-warning" role="alert">
        tout les champs de texte doivent être remplis
</div>');

    }
    $bdd = new PDO("pgsql:host=localhost;port=5432;dbname=postgres",'postgres','vm1');


?>
</div>
</body>
</html>