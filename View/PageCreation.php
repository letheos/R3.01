<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="PageCreationcss.css">
    <title>Document</title>
</head>
<body>

<style>

    /* Style pour masquer la bulle d'information */
    .info-bubble {
        display: none;
        position: absolute;
        background-color: #19f1f1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        z-index: 1;
    }

    /* Style pour le champ de mot de passe */
    #password {
        position: relative;
    }

    /* Style pour afficher la bulle lors du survol */
    #password:hover .info-bubble {
        display: block;
    }
</style>
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
        <option><?php echo (isset($_POST['menu']) && $_POST['menu'] == 'mph') ? 'selected' : ''; ?>>mph</option>
        <option> <?php echo (isset($_POST['menu']) && $_POST['menu'] == 'BUT informatique') ? 'selected' : ''; ?>>BUT informatique</option>
    </select>
    <br>
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
    $lasName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $mail = $_POST['email'];
    $login = $_POST['login'];
    $formation  = $_POST['menu'];



    if($pswd != $confirmation){
        echo ('<div class="alert alert-danger" role="alert">
            les deux mots de passe doivent être identiques
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
        == null||$confirmation == null ||$lasName == null||$mail ==null||$mail == null||$login == null||$formation == null){
        echo ('<div class="alert alert-warning" role="alert">
        tout les champs de texte doivent être remplis
</div>');

    }
}

?>

</body>
</html>