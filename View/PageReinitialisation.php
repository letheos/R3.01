<?php
session_start();

//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["login"])){
    $_SESSION['login'] = null;
}
//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["password"])){
    $_SESSION['password'] = null;
}
//Cette condition sert à verifier que la personne accedant a la page d'accueil
if ($_SESSION['login'] == null || $_SESSION['password'] == null) {
    //$_SESSION['provenance'] = 'Accueil';
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mot de passe oublié</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="StyleConnexion.css">
</head>


<body>
<section class="login">
    <div>
        <header>
            <h1>Mot de passe oubliée</h1>
        </header>
        <form method="post" action="../Controller/ControllerSendEmail.php">
            <input type="text" placeholder="Entrez email" name="login" id="login">
            <?php
            if(isset($_SESSION["erreur"])){
                ?>

                <div class="alert alert-danger">
                    <?php echo $_SESSION["erreur"]; ?>
                </div>

                <?php
                unset($_SESSION["erreur"]);
                session_destroy();
            }
            if (isset($_SESSION["success"])) {?>
                <div class="alert alert-success">
                    <?php  echo $_SESSION["success"] ?>
                </div>
                <?php
                unset($_SESSION["success"]);
                session_destroy();
            }
            ?>
        </form>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>

