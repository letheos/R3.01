<?php
session_start();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <title> Connexion !  </title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="StyleConnexion.css">
</head>

<body>
    <section class="login">
        <div>
            <header>
                 <h1> Se Connecter </h1>
            </header>

            <form method="post" action="../Controller/ControllerConnexion.php">
            <input type="text" id="login" name="login" placeholder="login"> <br>
            <input type="password" id="password" name="password" placeholder="password" >
            <button class="btn btn-outline-primary" type="submit" id="submit" name="submit"> Connexion </button> <br>
            <a href="../View/PageReinitialisation.php"> Mot de passe oublié ? </a>

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
            ?>
            </form>
        </div>
    </section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>

