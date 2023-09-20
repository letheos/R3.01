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
    <label for="lastName">Nom</label>

    <input type="text" name="lastName" value="<?php echo isset($_POST['lastName']) ? $_POST['lastName'] : ''; ?>">
    <br>
    <br>
    <label for="firstName">Prenom</label>
    <input type="text" name="firstName" value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : ''; ?>"><br>
    <br>
    <label for="mail">mail</label>
    <input type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"> <br>
    <br>
    <label for="login">Login</label>
    <input type="text" name="login" value="<?php echo isset($_POST['login']) ? $_POST['login'] : ''; ?>"><br>
    <br>
    <label for="formation">formation</label>
    <select name="menu" size="1" >
        <option>mph</option>
        <option>BUT informatique</option>
    </select>
    <br>
    <br>
    <label for="role">Rôle</label>
    <select name="role" size="1">
        <option value="Secretaire">Secrétaire</option>
        <option value="Chefdep">Chef de département</option>
        <option value ="Chargedev">Chargé de développement</option>
    </select>
    <div id="password">
        <br>
        <label for="password">mot de passe</label>
        <input type="password"  name="pswd">

        <div class="info-bubble">
            Le mot de passe doit contenir au moins 6 caractères , un chiffre et un caractère spécial (excepté " ' et ;).
        </div>
    </div>
    <br>
    <label for="confirmation">confirmation mot de passe </label>
    <input type="password" name="confirmation">
    <br>
    <button name="envoyer" class="btn btn-outline-primary" type="submit">inscription</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<?php


if (isset($_POST['envoyer'])){
    $pswd = $_POST['pswd'];
    $confirmation = $_POST['confirmation'];
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $mail = $_POST['email'];
    $login = $_POST['login'];
    $formation  = $_POST['menu'];



    if($pswd != $confirmation){
        echo ('<div class="alert alert-danger" role="alert">
            les deux mots de passe doivent être identiques
</div>');

    }

    elseif (preg_match('/[^A-Za-z0-9"\'\,\;]/', $lastName
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

    elseif (preg_match('/[^A-Za-z0-9"\'\,\;]/', $firstName
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

    elseif(preg_match('/[;\'"]/', $pswd
    )) {
        echo('<div class="alert alert-warning" role="alert">
        le mot de passe contient un caractère interdit
</div>');
    }
    elseif (!preg_match('/[^A-Za-z0-9"\'\,\;]/', $pswd
    )){
        echo('<div class="alert alert-warning" role="alert">
            le mot de passe doit au moins comprendre un caractère spécial
      </div>');
    }
    elseif (!preg_match("/[0-9]/", $pswd
    )){
        echo('<div class="alert alert-warning" role="alert">
                le mot de passe doit au moins comprendre un chiffre
          </div>');
    }

    elseif ($pswd
        == null||$confirmation == null ||$lastName == null||$mail ==null||$mail == null||$login == null||$formation == null){
        echo ('<div class="alert alert-warning" role="alert">
        tout les champs de texte doivent être remplis
</div>');

    }
    $bdd = new PDO("pgsql:host=localhost;port=5432;dbname=postgres",'postgres','aigle2430');
}

?>
</div>
</body>
</html>